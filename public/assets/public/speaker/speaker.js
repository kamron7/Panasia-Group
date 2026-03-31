var t2s_props = {
    isLoading: false,
    name: "",
    selectedVoice: 0,
    synth: window.speechSynthesis,
    voiceList: [],
    greetingSpeech: new window.SpeechSynthesisUtterance()
};

var sound_tooltip = null;
// console.log("greet", t2s_props.greetingSpeech)

$( document ).ready(function() {
    // console.log( "ready!" );
    $("#sound_tooltip").click(function(){
        greet();
        $(".sound_tooltip_img_container").addClass("spin")
    })

    t2s_props.voiceList = t2s_props.synth.getVoices();

    if (t2s_props.voiceList.length) {
        t2s_props.isLoading = false;
    }

    t2s_props.synth.onvoiceschanged = () => {
        t2s_props.voiceList = t2s_props.synth.getVoices();
    };

    listenForSpeechEvents();


    // selector for sound_tooltip
    sound_tooltip = document.getElementById("sound_tooltip");

    // return if error occured on startup
    if(!sound_tooltip) {
        console.error('[T2S] Plugin not initialized properly');
        return;
    }

    let selectedText = "";

    // listener for mouseup event
    document.body.addEventListener("mouseup", (e) => {
        $(".sound_tooltip_img_container").removeClass("spin")
        // debug
        // console.log(sound_tooltip.offsetWidth, sound_tooltip.offsetHeight)

        // return if sound_tooltip.id is equal with mouseup element.id or element children
        if (
            sound_tooltip.id === e.target.id ||
            e.target.closest("#" + sound_tooltip.id)
        )
            return;

        // stop speech if outside click
        t2s_props.synth.cancel();

        // return if window.getSelection().toString() is equal with selectedText
        if (selectedText == window.getSelection().toString()) {
            hideTooltip();
            return;
        }

        // set selectedText to compare in next loop
        selectedText = window.getSelection().toString();

        // if selectedText is less then 2 symbols hide sound_tooltip
        if (selectedText.length < 2) {
            hideTooltip();
            e.preventDefault();
            return;
        }

        // set sound_tooltip position from mouseup event clientX and clientY
        setTooltipPosition(e.clientX, e.clientY);

        e.preventDefault();
    }, false );

});
function setTooltipPosition(clientX, clientY) {
    sound_tooltip.classList.add("show");
    sound_tooltip.style = `top: ${clientY -
    sound_tooltip.offsetHeight / 2}px; left: ${clientX + 10}px`;
};

function hideTooltip() {
    sound_tooltip.classList.remove("show");

};

function listenForSpeechEvents() {
    t2s_props.greetingSpeech.onstart = () => {
        t2s_props.isLoading = true;
    };

    t2s_props.greetingSpeech.onend = () => {
        t2s_props.isLoading = false;
    };
};

function greet() {
// it should be 'craic', but it doesn't sound right
    t2s_props.greetingSpeech.text = window.getSelection().toString();

    t2s_props.greetingSpeech.voice = t2s_props.voiceList[
        t2s_props.selectedVoice
        ];
    // console.log("text select", t2s_props.greetingSpeech)
    t2s_props.synth.speak(t2s_props.greetingSpeech);
};