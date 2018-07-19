$(function() {
    $(document).on("click", "form[name=fwrite] button:submit", function() {
        var f = this.form;
        var bo_table = f.bo_table.value;
        var token = get_write_token(bo_table);

        if(!token) {
            alert(g5_msg_token_info_not_correct);
            return false;
        }

        var $f = $(f);

        if(typeof f.token === "undefined")
            $f.prepend('<input type="hidden" name="token" value="">');

        $f.find("input[name=token]").val(token);

        return true;
    });
});
