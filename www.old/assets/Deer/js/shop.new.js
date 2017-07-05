$(function(){

    var isiShop = {
        variables: {
            currency: 'wmr',
            currency_str: 'руб.',
            discountPercent: 0,
            createPayment: false,
            storage: localStorage
        },
        generateSum: function(count) {
            if (count > this.variables.good_count)
            {
                $('.choose_popup #currency').hide();
                return 'Такого кол-ва товара нет';
            }
            else
            {
                var sum;
                sum = count * this.getCurrency();
                sum = this.generateSumDiscount(sum);

                if (this.variables.currency == 'qiwi')
                    return sum.toFixed(2);
                else
                    return Math.ceil(sum * 100) / 100; // 1.001 -> 1.01
                    //return parseFloat(sum.toFixed(3)); // 1.1, but 1.001
            }
        },
        getCurrency: function(){
            var price;
            if (this.variables.currency == 'wmz')
            {
                price = this.variables.good_priceusd;
                this.variables.currency_str = '$';
            }
            else
            {
                price = this.variables.good_pricerub;
                this.variables.currency_str = 'руб.';
            }
    
            $('.choose_popup #currency').show().text(this.variables.currency_str);
    
            return price;
        },
        generateSumDiscount: function(sum) {
            if (this.variables.discountPercent > 0)
            {
                sum = sum - (sum / 100 * this.variables.discountPercent);
            }
    
            return sum;
        },
        onWindowClose: function(){
            if (this.variables.createPayment === true)
            {
                return 'Вы уверены, что хотите прервать процесс покупки?';
            }
        },
        onPopupClose: function(){
            if (this.variables.createPayment === true)
            {
                return confirm('Вы уверены, что хотите прервать процесс покупки?');
            } else { return true; }
        }
    };

    /**
     * Оплата с помощью вебмани не прерывает процесс покупки
     */
    $(document).on('click', '#btnwmk', function(){
        isiShop.variables.createPayment = false;
    });

    window.onbeforeunload = function(e) {
        return isiShop.onWindowClose();
    };
    
    $(document).on('click', '.choose_popup .fa-times, .success_popup .fa-times', function(e){
        if (isiShop.onPopupClose())
        {
            $("#overlay, .choose_popup, .success_popup").fadeOut("slow");
            $('body').removeClass('popup-open');
            isiShop.variables.createPayment = false;
        }
    });
    
    $(document).keyup(function(e) {
        if (e.keyCode == 27 && isiShop.onPopupClose()) {
            $("#overlay, .choose_popup, .success_popup").fadeOut("slow");
            $('body').removeClass('popup-open');
            isiShop.variables.createPayment = false;
        }
    });
    
    /**
     * Открываем попап
     */
    $(document).on('click', 'a.buy, .good-container', function(e){
        var $popup = $('.choose_popup');

        var tr = $(this).parents('tr'),
            dData = $(this);

        if (tr.length > 0)
        {
            data = tr.data();
        }
        else
        {
            data = dData.data();
        }
    
        $('.order_popup').remove(); // if last form already exists
        $('#order').show();
        $('body').addClass('popup-open');
    
        $.each(data, function(i, elem){
            isiShop.variables['good_' + i] = elem;
        });
    
        isiShop.variables.discountPercent = 0;
    
        $popup.find('#good_title').text(data.title);
        $popup.find('#good_count').val(data.mincount);
        $popup.find('#discount_code').val('');

        $('.choose_popup #sum').text(isiShop.generateSum(data.mincount)); // дефолтная сумма по мин кол-ву акков
    
    
        $("#overlay, .choose_popup").fadeIn("slow");

        if (isiShop.variables.storage.getItem('lastorder') != null)
        {
            $('#btn-window').show();
        }

        return false;
    });

    /**
     * Открываем попап с данными из "Закрыли окно?"
     */
    $("#btn-window").on('click', function (e) {
        $('#order').hide();
        $('.choose_popup .popup-modal').append(isiShop.variables.storage.getItem('lastorder'));
        $('#btn-window').hide();
    });
    
    /**
     * Кол-во аккаунтов может быть только целым числом
     * Расчитываем сумму заказа
     */
    $("#good_count").on('keydown keyup', function (e) {
        // Allow: backspace, delete, tab, escape, enter
        if ($.inArray(e.keyCode, [46, 9, 27, 13, 110]) !== -1 ||
                // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) ||
                // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
            // let it happen, don't do anything
            return;
        }
    
        // Ensure that it is a number and stop the keypress, 8 == backspace
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105) && e.keyCode != 8) {
            e.preventDefault();
        }
    
        if (e.type == 'keyup')
        {
            var count = this.value || 0;
            $('.choose_popup #sum').text(isiShop.generateSum(count));
        }
    });
    
    /**
     * Получаем сумму скидки
     */
    $('#discount_code').on('keydown keyup paste', function (e) {
        var dv = this.value,
            action = $(this).attr('data-action'),
            count = $("#good_count").val() || 0;
    
        if (e.type == 'keyup')
        {
            if (dv.length == 11)
            {
                $.post(action, { code: dv, gid: isiShop.variables.good_id, shop: isiShop.variables.good_shopid }, function(json){
                    if (json.ok)
                    {
                        isiShop.variables.discountPercent = parseInt(json.percent);
                        $('.choose_popup #sum').text(isiShop.generateSum(count))
                    }
                    else
                    {
                        isiShop.variables.discountPercent = 0;
                        $('.choose_popup #sum').text(isiShop.generateSum(count))
                    }
                }, 'json');
            }
            else
            {
                isiShop.variables.discountPercent = 0;
                $('.choose_popup #sum').text(isiShop.generateSum(count))
            }
        }
    });

    /**
     * Выбираем метод оплаты
     */
    $(document).on('change', 'select[name=paymethod]', function(){
        isiShop.variables.currency = $(this).val();
        var count = $("#good_count").val() || 0;
        $('.choose_popup #sum').text(isiShop.generateSum(count));
    });

    $(document).on('click', 'input.clipboard', function(){
        this.select();
    });

    $(document).on('click', '.order_popup h4 .close', function(){
        $('.order_popup').remove();
        $('#buy-btn').attr('disabled', false);
    });

    function validateEmail(email){
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }

    // Создание заказа
    $(document).on('submit', '#order', function(event){
        var dataS = $(this).serialize();

        if (typeof isiShop != 'undefined')
        {
            var link = $(this).attr('action'),
                email = $('input[name=email]', this).val(),
                count = $('input[name=count]', this).val() || 0,
                goodid = isiShop.variables.good_id,
                min_count = isiShop.variables.good_mincount,
                paymethod = $('select[name=paymethod]', this).val(),
                count_accs = isiShop.variables.good_count;

            dataS = dataS + '&type=' + goodid;
        }

        if (!validateEmail(email))
        {
            alert('Укажите Email адрес');
            return false;
        }

        if (parseInt(count) < parseInt(min_count))
        {
            alert('Мин. кол-во товара ' + min_count);
            return false;
        }

        if (parseInt(count_accs) < parseInt(count))
        {
            alert('Такого количества товара нет');
            return false;
        }

        if (paymethod == 0)
        {
            alert('Выберите способ оплаты');
            return false;
        }

        $.ajax({
            type: "POST",
            url: link,
            data: dataS,
            dataType: "json",
            success: function(json) {
                if (json.order)
                {
                    $('#order').hide();
                    $('.choose_popup .popup-modal').append(json.order);

                    isiShop.variables.storage.setItem('lastorder', json.order);
                    isiShop.variables.createPayment = true;
                    $('#btn-window').hide();
                }
                else
                if (json.errors)
                {
                    if (json.errors.global)
                        alert(json.errors.global);
                    else
                    if (json.errors.pay)
                        alert(json.errors.pay);
                }
            },
            error: function(data){
                console.log(data);
                alert('Временная ошибка сервера. Попробуйте еще раз!');
            }
        });

        event.preventDefault();
    });

    var hasLink = '';
    // Проверка оплаты товара
    $(document).on('submit', '#pay', function(event){
        var chk = $('.check_pay .check'),
            link = $(this).attr('action');

        chk.addClass('loading').html('');
        $('.check_pay input[type="submit"]').prop('disabled', true);

        var dataS = $(this).serialize();

        $.ajax({
            type: "POST",
            url: link,
            data: dataS,
            dataType: "json",
            success: function(json) {
                chk.removeClass('loading');
                $('.check_pay input[type="submit"]').prop('disabled', false);

                if (typeof json.redirect != 'undefined')
                {
                    isiShop.variables.createPayment = false;
                    isiShop.variables.storage.removeItem('lastorder');

                    window.location.href = json.redirect;
                }
                else
                if (json.errors || (json.ok && json.link) || hasLink != '')
                {
                    if (!json.errors || json.errors.payed)
                    {
                        isiShop.variables.createPayment = false;
                        isiShop.variables.storage.removeItem('lastorder');

                        hasLink = json.link || hasLink;

                        $('.check_pay .check').html(hasLink);
                    }

                    if (json.errors.global) $('.check_pay .check').html(json.errors.global);
                }
            },
            error: function(data){
                console.log(data);
                chk.removeClass('loading');
                $('.check_pay input[type="submit"]').prop('disabled', false);
                $('.check_pay .check').html('Временная ошибка сервера. Попробуйте еще раз!');
            }
        });

        event.preventDefault();
    });
});