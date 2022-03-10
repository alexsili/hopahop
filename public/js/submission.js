var Submission = {

    init: function () {

        Submission.addAuthor();
        Submission.removeAuthor();
        Submission.hideAuthor();
        Submission.addFiles();
        Submission.removeFile();
    },

    getToken: function () {
		return $('meta[name="token"]').attr('content');
	},
    resetAuthorNo: function() {
        var id = 1;
        $(".author-row").each(function (index) {
            $(this).find('.author-row-id').html(id);
            id++;
        });
    },
    addAuthor: function () {

        $('body').on('click', '.addAuthor', function (e) {
            e.preventDefault();

            var firstName = $(this).closest("div#author-container").find("input[name='first_name[]']");
            if (firstName.val() == '') {
                let inputs = $(this).closest("div#author-container").find('input, select');
                inputs.addClass('is-invalid');
                inputs.after('<span class="invalid-feedback">This field cannot be empty</span>');

                return false;
            }

            var id = $(this).data("id");
            const author = $('.author-row' + id);

            $('select').select2('destroy');

            var authorContainerClone = author.clone();
            var newId = id + 1;

            $(this).closest('div.btn-container').find('label').html('Remove Author');
            var btn = $(this).closest('div.btn-plus').find('button');

            btn.removeClass('btn-primary');
            btn.removeClass('addAuthor');
            btn.addClass('btn-danger');
            btn.addClass('removeAuthor');
            btn.addClass('hideAuthor');
            btn.html('-');

            authorContainerClone.find('.author-row-id').html(newId);
            authorContainerClone.find('.addAuthor').attr('data-id', newId);
            authorContainerClone.removeClass('author-row' + id);
            authorContainerClone.addClass('author-row' + newId);

            authorContainerClone.find('input[type=text]').each(function(){
                let name = $(this).attr('name');
                let newName = name.replace('['+id+']', '['+newId+']');

                $(this).attr('name', newName);
            });

            let newAuthorSelect = authorContainerClone.find('select');
            let AuthorSelectName = newAuthorSelect.attr('name');
            let newAuthorSelectName = AuthorSelectName.replace('['+id+']', '['+newId+']');
            newAuthorSelect.attr('name', newAuthorSelectName);

            authorContainerClone.find('input,select').val("");

            $('.author-row' + id).after(authorContainerClone);

            $('select').select2({});

            Submission.resetAuthorNo();
        });
    },

    hideAuthor: function () {
        $('body').on('click', '.hideAuthor', function (e) {
            e.preventDefault();

            $(this).parents(':eq(2)').fadeTo(150, 0.01, function(){
                $(this).slideUp(50, function() {
                    $(this).remove();
                });
            });
        });
    },

    removeAuthor: function () {
        $('body').on('click', '.removeAuthor', function (e) {
            e.preventDefault();
            return false;
        });
    },

    addFiles: function () {
        $('body').on('click', '.addFiles', function (e) {
            e.preventDefault();

            var id = $(this).data("id");
            var newId = id + 1;

            const moreFiles = $('.more-files-container' + id);
            var moreFilesClone = moreFiles.clone();

            $(this).closest('div.more-files-container' + id).find('label').html('Remove File');
            var btn = $(this).closest('div.more-files-container' + id).find('button');
            btn.removeClass('btn-primary');
            btn.removeClass('addFiles');
            btn.addClass('btn-danger');
            btn.addClass('removeFile');
            btn.html('-');

            moreFilesClone.find('.addFiles').attr('data-id', newId);
            moreFilesClone.removeClass('more-files-container' + id);
            moreFilesClone.addClass('more-files-container' + newId);

            $('.more-files-container' + id).after(moreFilesClone);
        });
    },

    removeFile: function () {
        $('body').on('click', '.removeFile', function (e) {
            e.preventDefault();

            let container;
            const type = $(this).data('type');
            const id = $(this).data('id');

            if(type == 'submissionFile') {
                container = $('body .submissionFile');
                $('.submissionFileInput').removeClass('d-none');
            }
            if(type == 'coverLetterFile') {
                container = $('body .coverLetterFile');
                $('.coverLetterFileInput').removeClass('d-none');
            }
            if(type == 'supplementaryFile') {
                container = $('body .supplementaryFile'+id);
            }

            if(type == 'author') {
                container = $('body .author-row'+id);
            }

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': Submission.getToken()
                },
                type: "POST",
                url: $(this).parent().attr('action'),
                data: {
                    form:$(this).serialize()
                },
                success: function (data) {
                    $('.modal').modal('hide');

                    if(container != undefined) {
                        container.remove();
                    }

                    $(this).parents(':eq(2)').remove();
                }
            });

        });
    }
}

$(document).ready(function () {
    Submission.init();
});
