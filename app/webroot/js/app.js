/**
 * Main JS App file.
 * This file contains any utility functions used by the app.
 *
 * (c) 2015 Dynamictivity LLC
 */

$(document).ready(function () {

    // HSEAPP-4: Disable the submit buttons after clicking them.
    var disableSubmitButtonsAfterClick = function () {
        $("form[method='post']").on('submit', function () {
            $("input[type='submit']").prop('disabled', true);
            $("[type='button']").prop('disabled', true);
            //$("input[type='submit']").val("Working...");
        });
        $("[type='button']").on('click', function () {
            $("input[type='submit']").prop('disabled', true);
            $("[type='button']").prop('disabled', true);
        });
    };

    disableSubmitButtonsAfterClick();
});