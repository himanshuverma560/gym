(function ($) {
    "use strict";
    $(document).ready(function () {
        tinymce.init({
            selector: ".summernote",
            plugins:
                "anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount ",
            toolbar:
                "undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat",
            tinycomments_mode: "embedded",
            tinycomments_author: "Author name",
            mergetags_list: [
                {
                    value: "First.Name",
                    title: "First Name",
                },
                {
                    value: "Email",
                    title: "Email",
                },
            ],
        });
        $(".select2").select2();
        $(".sub_cat_one").select2();
        $(".tags").tagify();
        $(".datetimepicker_mask").datetimepicker({
            format: "Y-m-d H:i",
        });

        $(".custom-icon-picker").iconpicker({
            templates: {
                popover:
                    '<div class="iconpicker-popover popover"><div class="arrow"></div>' +
                    '<div class="popover-title"></div><div class="popover-content"></div></div>',
                footer: '<div class="popover-footer"></div>',
                buttons:
                    '<button class="iconpicker-btn iconpicker-btn-cancel btn btn-default btn-sm">Cancel</button>' +
                    ' <button class="iconpicker-btn iconpicker-btn-accept btn btn-primary btn-sm">Accept</button>',
                search: '<input type="search" class="form-control iconpicker-search" placeholder="Type to filter" />',
                iconpicker:
                    '<div class="iconpicker"><div class="iconpicker-items"></div></div>',
                iconpickerItem:
                    '<a role="button" href="javascript:;" class="iconpicker-item"><i></i></a>',
            },
        });
        $(".datepicker").datepicker({
            format: "yyyy-mm-dd",
            startDate: -Infinity,
        });
        $(".clockpicker").clockpicker({
            donetext: 'Done'
        });
    });

    $("#setLanguageHeader").on("change", function (e) {
        this.submit();
    });

    const inputSelector = "#search_menu";
    const listSelector = "#admin_menu_list";

    function filterMenuList() {
        const query = $(inputSelector).val().toLowerCase();
        $(listSelector + " a").each(function () {
            const areaName = $(this).text().toLowerCase();
            $(this).toggle(areaName.includes(query));
        });
    }

    $(inputSelector).on("input focus", function () {
        filterMenuList();
        $(listSelector).removeClass("d-none");
    });
    $(document).on("click", function (e) {
        if (
            !$(e.target).closest(inputSelector).length &&
            !$(e.target).closest(listSelector).length
        ) {
            $(listSelector).addClass("d-none");
        }
    });

    $(".change-currency").on("change", function (e) {
        $(".set-currency-header").submit();
    });


    // Nice select
    $(".select_js").niceSelect();
})(jQuery);
