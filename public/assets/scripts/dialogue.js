let url = new URL(window.location.href)
let dialogues = []
let game
let npc
let typing = false
let timeout

if (url.pathname === '/') {
    npc = 'intro'
} else {
    npc = document.getElementById('main').dataset.npc
}

fetch(`/api/dialogues`, {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
    },
    body: JSON.stringify({
        npc: npc
    }),
})
    .then(response => response.json())
    .then(data => {
        dialogues = data['dialogues']
        game = data.hasOwnProperty('game') ? data['game'] : null;

        showDialogue(dialogues[currentDialogueIndex])
        document.getElementById('dialogue').addEventListener('click', skipDialogue)
    })
    .catch((error) => {
        console.log('Error:', error)
    })

let currentDialogueIndex = 0

function showDialogue(dialogue) {
    buildText(document.getElementById('dialogue-text'), dialogue.text)
    document.getElementById('head').src = `/assets/images/characters/${dialogue['speaker_img']}/${dialogue['speaker_img']}_head.png`
    document.getElementById('name').textContent = dialogue['speaker_name']
}

function nextDialogue() {
    currentDialogueIndex++
    if (currentDialogueIndex < dialogues.length) return showDialogue(dialogues[currentDialogueIndex])
    if (game === null) return window.location.href = `/home`
    window.location.href = `/games/${game}`
}

function skipDialogue(){
    if (typing === true){
        timeout = null;
    }else{
        nextDialogue();
    }
}

function buildText(element, text) {
    timeout = 25
    element.textContent = '';
    let lines = text.split('<br>');
    let charIndex = 0;
    let lineIndex = 0;
    let textNode = document.createTextNode('')

    function typeLine() {
        typing = true
        if (lineIndex < lines.length) {
            if (textNode.length === 0) element.appendChild(textNode)
            if (charIndex <= lines[lineIndex].length) {
                textNode.textContent += lines[lineIndex].charAt(charIndex)
                charIndex++
                setTimeout(typeLine, timeout)
            } else {
                textNode = document.createTextNode('')
                element.appendChild(document.createElement('br'))
                charIndex = 0
                lineIndex++
                setTimeout(typeLine, timeout)
            }
        } else {
            typing = false
        }
    }
    typeLine()
}
