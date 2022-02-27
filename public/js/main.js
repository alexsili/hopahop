var Main = {

    init: function () {
        Main.select2Apply();
    },

    select2Apply: function () {
        $('.select2').select2({});
    }
};

$(document).ready(function () {
    Main.init();
});

