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
    /*this function is for hiding the video nav bar*/
    var timeout = null;
    $(document).on("mousemove", function()
    {
        clearTimeout(timeout);
        $(".watchNav").fadeIn();
        //if mouse moved, the watchNav bar fade in
        timeout = setTimeout(function()
        {
            $(".watchNav").fadeOut();
        }, 1200); //after 1,2 secs, the watchNav will fade out
    })
}

function initVideo(videoId, username)
{
    startHideTimer();
    updateProgressTimer(videoId, username);
    setStartTime(videoId, username);
}

function updateProgressTimer(videoId, username)
{
    addDuration(videoId, username);

    var timer;
    //do this anon function in here IF video is playing
    $("video").on("playing", function(event)
    {
        window.clearInterval(timer); //stop the timer and start the new one
        //get the CURRENT time of the video WITH videoId and username
        timer = window.setInterval(function()
        {
            updateProgress(videoId, username, event.target.currentTime);
        }, 3000);
    })
    //if the video is finished, reset the timer to 0
    .on("ended", function()
    {
        setFinished(videoId, username); //with on("ended") function, run this code
        window.clearInterval(timer);
    })
}

function addDuration(videoId, username)
{
    /*make an ajax call, send data with ".post" 
    parsed in videoId and username variable with a data variable from anonymous function*/
    $.post("ajax/addDuration.php", { videoId: videoId, username: username }, function(data)
    {
        if(data !== null && data !== "")
        {
            alert(data);
        } 
    })
}

function updateProgress(videoId, username, progress)
{
    $.post("ajax/updateDuration.php", { videoId: videoId, username: username, progress: progress }, function(data)
    {
        if(data !== null && data !== "")
        {
            alert(data);
        } 
    })
}

function setFinished(videoId, username)
{
    $.post("ajax/setFinished.php", { videoId: videoId, username: username }, function(data)
    {
        if(data !== null && data !== "")
        {
            alert(data);
        } 
    })
}

function setStartTime(videoId, username)
{
    $.post("ajax/getProgress.php", { videoId: videoId, username: username }, function(data)
    {
        if(isNaN(data)) //if it's not a number, return error
        {
            alert(data);
            return;
        }
        $("video").on("canplay", function() //on video page, set the current time to data(which is the value that got parsed from database)
        {
            this.currentTime = data;
            $("video").off("canplay"); //
        })
    })
}