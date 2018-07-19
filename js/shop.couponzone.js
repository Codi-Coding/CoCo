$(function() {
    $("button.coupon_download").on("click", function() {
        if(g5_is_member != "1") {
            alert(g5_msg_use_after_login);
            return false;
        }

        var $this = $(this);
        var cz_id = $this.data("cid");

        if($this.hasClass("disabled")) {
            alert(g5_msg_downloaded_coupon);
            return false;
        }

        $this.addClass("disabled").attr("disabled", true);

        $.ajax({
            type: "GET",
            data: { cz_id: cz_id },
            url: g5_url+"/shop/ajax.coupondownload.php",
            cache: false,
            async: true,
            dataType: "json",
            success: function(data) {
                if(data.error != "") {
                    $this.removeClass("disabled").attr("disabled", false);
                    alert(data.error);
                    return false;
                }

                $this.attr("disabled", false);
                alert(g5_msg_coupon_published);
            }
        });
    });
});
