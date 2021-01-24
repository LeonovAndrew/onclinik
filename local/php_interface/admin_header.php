<script>
    $(document).ready(function () {
        $("#del_continue").click(function (e) {
            e.preventDefault();
            var id = jQuery('#result_del').html();
            $.ajax({
                type: "POST",
                url: "/ajax/pdo/delprice.php",
                data: ({action: 'continue', id: id}),
                success: function (data) {
                    jQuery('#result_del').html(data);
                    jQuery('.pdo_del_price').css({'display': 'block'});
                    jQuery('#del_continue').css({'display': 'block'});
                }
            });
        });

        $("#del_start").click(function (e) {
            e.preventDefault();
            // $("#del_start").hide();
            $.ajax({
                type: "POST",
                url: "/ajax/pdo/delprice.php",
                data: ({action: 'start', id: '0'}),
                success: function (data) {
                    jQuery('#result_del').html(data);
                    jQuery('.pdo_del_price').css({'display': 'block'});
                    jQuery('#del_continue').css({'display': 'block'});
                }
            });
        });

        $("#del_synchr").click(function (e) {
            e.preventDefault();
            $("#del_synchr").hide();
            $.ajax({
                type: "POST",
                url: "/ajax/pdo/delsynchr.php",
                data: ({action: 'start', id: '0'}),
                success: function (data) {
                    jQuery('#result_del_synchr').html(data);
                    jQuery('.pdo_del_synchr').css({'display': 'block'});
                }
            });
        });

        $("#price_continue").click(function (e) {
            e.preventDefault();
            var id = jQuery('#result').html();
            $.ajax({
                type: "POST",
                url: "/ajax/pdo/addprice.php",
                data: ({action: 'continue', id: id}),
                success: function (data) {
                    jQuery('#result').html(data);
                    jQuery('.pdo_add_price').css({'display': 'block'});
                    jQuery('#price_continue').css({'display': 'block'});
                }
            });
        });
        $("#price_start").click(function (e) {
            e.preventDefault();
            $("#price_start").hide();
            $.ajax({
                type: "POST",
                url: "/ajax/pdo/addprice.php",
                data: ({action: 'start', id: '0'}),
                success: function (data) {
                    jQuery('#result').html(data);
                    jQuery('.pdo_add_price').css({'display': 'block'});
                    jQuery('#price_continue').css({'display': 'block'});
                }
            });
        });

        $("#synchr_start").click(function (e) {
            e.preventDefault();
            // $("#synchr_start").hide();
            $.ajax({
                type: "POST",
                url: "/ajax/pdo/synchrprice.php",
                data: ({action: 'start', id: '0'}),
                success: function (data) {
                    jQuery('#result2').html(data);
                }
            });
        });


        $(document).ajaxStart(function () {
            $("#loading").show();
        });
        $(document).ajaxStop(function () {
            $("#loading").hide();
        });
    });
</script>
<style>
    .warning{
        color: red;
    }
    .pdo_ul{
        list-style-type: decimal;
    }
    .pdo_del_price, .pdo_del_synchr, .pdo_add_price, #price_continue, #del_continue {
        display: none;
        padding: 10px;
    }

    #loading {
        display: none;
        position: fixed;
        z-index: 1000;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        background: rgba(181, 181, 181, 0.5) url('loader.gif') 50% 50% no-repeat;
    }
</style>