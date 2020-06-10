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