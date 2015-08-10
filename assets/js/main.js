var checkConfirm = 0;

$('.confirm').on('click', function() {
	checkConfirm = 1;
});

$('form').on('submit', function() {
	if (checkConfirm == 1) {
		checkConfirm = 0;
		return confirm('Are you sure you want to proceed?');
	}
});

$('.confirmLink').on('click',  function(e) {

	e.stopPropagation();
	e.preventDefault();

	var url = $(this).attr("href");

	$.get(url);

	$(this).closest('.row').remove();

});

$('.editcomment').on('click',  function(e) {

	e.stopPropagation();
	e.preventDefault();

	$(this).parent().parent().find(".name .actual").css('display','none');
	$(this).parent().parent().find(".name .edit").css('display','block');

});


$('.editcommentconfirm').on('click',  function(e) {

	e.stopPropagation();
	e.preventDefault();

	var url = $(this).attr("href");
	var comment = $(this).parent().find(".message").val();

	$.post(url, {comment: comment});

	$(this).parent().parent().find(".actual").css('display','block');
	$(this).parent().parent().find(".edit").css('display','none');

	$(this).parent().parent().find(".actual").html('Updated...');

});