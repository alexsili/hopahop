var Main = {
    currUrl: '',

    getToken: function () {
        return $('meta[name="token"]').attr('content');
    },

    init: function () {

        Main.select2Apply();
        Main.removeReviewerBtn();
        Main.removeReviewer();

    },

    select2Apply: function () {

        $('.select2').select2({
            // minimumResultsForSearch: Infinity,
            // allowClear: true
        });

    },

    removeReviewerBtn: function () {

        $("body").on("click", ".remove-reviewer-btn", function () {
            let userId = $(this).data('id');
            $('#remove-reviewer-id').val(userId);
        });
    },

    removeReviewer: function () {

        $("body").on("click", "#remove-reviewer", function () {

            let userId = $('#remove-reviewer-id').val();
            let submissionId = $('#submission-id').val();

            let url = $(location).attr('href'),
                parts = url.split("/"),
                reviewerIds = parts[parts.length - 1].split("-");

            reviewerIds = reviewerIds.filter(item => item !== userId).toString().replaceAll(',', '-');

            if (reviewerIds.length > 0) {
                document.location = '/editor/confirm-selected-reviewers/' + submissionId + '/' + reviewerIds + '';
            } else {
                document.location = '/editor/select-reviewers/' + submissionId;
            }
        });

    },

};

$(document).ready(function () {
    Main.init();
});
