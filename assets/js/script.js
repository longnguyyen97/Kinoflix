function volumeToggle(button)
{
    //if click when muted, set unmute and vise versa
    var muted = $(".previewVideo").prop("muted");
    $(".previewVideo").prop("muted", !muted);

    //if clicked, change button
    $(button).find("i").toggleClass("fa-volume-mute");
    $(button).find("i").toggleClass("fa-volume-up");
}

function previewEnded()
{
    $(".previewVideo").toggle()
    $(".previewImage").toggle()
}

function goBack()
{
    window.history.back();
}

function startHideTimer()
{
    var timeout = null;
    $(document).on("mousemove", function()
    {
        clearTimeout(timeout);
        $(".watchNav").fadeIn();

        timeout = setTimeout(function()
        {
            $(".watchNav").fadeOut();
        }, 1200);
    })
}

function initVideo()
{
    startHideTimer();
}