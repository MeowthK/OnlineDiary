$(document).ready(function(){

    $("#diary-date").on("change", function(){

        let diaryDate = GetDate(new Date($("#diary-date").val()));
        let currentDate = GetDate();
        let placeholder = "How was your day? :)";
        let entryReadOnly = false;

        $("#delete-confirmation").hide();

        if (Date.parse(diaryDate) > Date.parse(currentDate))
            $("#diary-date").val(currentDate);

        $("#diary-entry").load("load-entry.php?entrydate=" + diaryDate);

        if (diaryDate == currentDate)
        {
            $("#delete").hide();
            $("#submit").show();
        }
        else
        {
            placeholder = "You haven't written this day :(";
            entryReadOnly = true;

            $("#delete").show();
            $("#submit").hide();
        }

        $("#diary-entry").prop("placeholder", placeholder);
        $("#diary-entry").prop("readonly", entryReadOnly);

    });

    $("#delete").click(function(){

        if ($("#diary-entry").val().length > 0)
            $("#delete-confirmation").show();

    });

    $("#cancel").click(function(){

        $("#delete-confirmation").hide();

    });

    $("#delete-confirm").click(function(){
        
        $("#delete-final").click();

    });

});

function GetDate(date = new Date())
{
    let returnDate = date.getFullYear() + "-" + PadString((date.getMonth() + 1), 0, 2) + "-" + PadString(date.getDate(), 0, 2);
    return returnDate;
}

function PadString(phrase, padding = "0", padCount = 0)
{
    phrase = phrase.toString();

    let phraseLength = phrase.length;
    let currentPadding = padCount - phraseLength;

    for (let i = 0; i < currentPadding; i++)
        phrase = padding + phrase;

    return phrase;
}
