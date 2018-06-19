$(function(){
    //class on click example
    //$(document).on("click", ".my-class", function(){
        //do something
    //});

    //hide alerts
    // $("#system-alert").slideUp("slow");
    setTimeout(function(){
        $("#system-alert").slideUp("slow");
    }, 1800);

    //click to call js submit for single/generic form
    $(document).on("click", ".js-submit-btn", function(){
        submitJSForm();
    });

    $("#js-pw-check").click(function() {
        if($('input[name=newpassword]').val() == $('input[name=passwordconfirm]').val()){
            submitJSForm();
        }
        else{
            $('#passwordconfirm').css('border-color', '#AA4444');
            $('#passwordconfirm').css('background-color', '#FCD6D6');
            $(document).scrollTop($("#passwordconfirm").offset().top); 
        }
    });
    //also prompt with error if you unfocus with mismatching passswords
    $('#passwordconfirm').blur(function(){
        if($('input[name=newpassword]').val() == $('input[name=passwordconfirm]').val()){
            $('#passwordconfirm').removeAttr( 'style');
        }
        else{
            $('#passwordconfirm').css('border-color', '#AA4444');
            $('#passwordconfirm').css('background-color', '#FCD6D6');
        }
    });

    //clears forms on modal closing, hides hidden elements and shows hidden elements that should be unhidden
    //using .on() because we're using a class name... this will clear all forms on a page
    $(".form-modal").on("hidden.bs.modal", function () {
        $('form').trigger("reset");
        //rehide any unhidden form elements or show any default non-hidden classes that GOT hidden
        $('.form-hidden').addClass("hidden");
        $(".default-show").removeClass("hidden");
    });

    //kakikomi js
    //open nav
    $("#kaki-logo").click(function() {
        $("#kakikomi-menu").addClass('open');
        $("#click-away").addClass('on');
        $("#kaki-logo").addClass('on');
    });

    //close nav
    $(document).on("click", ".menu-logo", function(){
        $("#kakikomi-menu").removeClass('open');
        $("#click-away").removeClass('on');
        //match css transition for nav + 20
        setTimeout(function(){
            $("#kaki-logo").removeClass('on');
        }, 420);
    });

    $(document).on("click", "#click-away.on", function(){
        $("#kakikomi-menu").removeClass('open');
        $("#click-away").removeClass('on');
        //match css transition for nav + 20
        setTimeout(function(){
            $("#kaki-logo").removeClass('on');
        }, 420);
    });

    //write
    //--prevent form submit on enter
    $('#write-form').on('keyup keypress', function(e) {
      var keyCode = e.keyCode || e.which;
      if (keyCode === 13) { 
        e.preventDefault();
        return false;
      }
    });

    //--save draft
    $(document).on("click", ".save-draft-btn", function(){
        $('input[name="published-input"]').val('0');
        submitJSForm("write-form");
    });

    //--open tags
    $("#tags-btn").click(function() {
        $(".tags-container").toggleClass('open');
    });

    //tag-add-btn
    $(document).on("click", ".add-tag-btn", function(){
        var tagsArray = [];
        var tagInput = $('input[id="tag-input"]').val();
        tagsArray.push(tagInput);
        $('input[id="tag-input"]').val('');
        console.log("this is the tagsArray "+tagsArray;

        // var ul = document.getElementById("list");
        // var li = document.createElement("li");
        // li.appendChild(document.createTextNode("Four"));
        // ul.appendChild(li);
    });

    //modal launch and submits
    //--delete
    $(document).on("click", ".delete-post-btn", function(){
        var deleteUID = $(this).data('uid');
        var deleteTitle = $(this).data('title');
        $(".print-post-title").text(deleteTitle);
        $('input[name="delete-uid"]').val(deleteUID);
    });

    //--delete--click to call js submit delete form
    $("#delete-budget-submit-btn").click(function(){
        if(($('#delete-you-sure-1').is(':checked'))&&($('#delete-you-sure-2').is(':checked'))&&($('#delete-you-sure-3').is(':checked'))){
            submitJSForm("post-delete-form");
        }
        else{
            $("#must-check-to-delete").addClass("text-danger bold");
            $("#must-check-to-delete").removeClass("text-success");
            $("#must-check-to-delete").removeClass("d-none");
        }
    });

    //--delete--check state of checks to remove disable
    $('.delete-you-sure').change(function(){
        if(($('#delete-you-sure-1').is(':checked'))&&($('#delete-you-sure-2').is(':checked'))&&($('#delete-you-sure-3').is(':checked'))){
            $("#must-check-to-delete").addClass("text-success bold");
            $("#must-check-to-delete").removeClass("text-danger");
            $("#must-check-to-delete").removeClass("hidden");
            $("#must-check-to-delete").text("Alright, now all you have to do is hit that button!");
            $("#delete-budget-submit-btn").removeClass("disabled");
        }
        else{
            $("#must-check-to-delete").removeClass("text-success");
            $("#delete-budget-submit-btn").addClass("disabled-fade");
        }
    });

})

//reordering auto-ajax function
function updateOrder(uid, pos){
    $.ajax({
        type: "POST",
        data: {moveuid: uid, movepos: pos},
        cache: false,
        success: function(response){
            //$(".reorder-badge").show().delay(500).fadeOut("fast");
        }
    });
}

//js form submit function
function submitJSForm(formid){
    //either provide a form id or to use the generic function, make sure form has id #js-submit-form and is the only form on the page
    formid = formid || "js-submit-form";
    document.getElementById(formid).submit();
}