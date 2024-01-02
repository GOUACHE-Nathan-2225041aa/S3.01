const npc = document.getElementById('game_screen').dataset.npc
let dialogues = []
let game

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
        game = data['game']

        showDialogue(dialogues[currentDialogueIndex])
    })
    .catch((error) => {
        console.log('Error:', error)
    })

let currentDialogueIndex = 0

function showDialogue(dialogue) {
    buildText(document.getElementById('dialogue-text'), dialogue.text)
    document.getElementById('head').src = `/assets/images/characters/${dialogue['speaker_img']}/${dialogue['speaker_img']}_head.png`
    document.getElementById('name').textContent = dialogue['speaker_name']
    if (!dialogue.hasOwnProperty('display_character')) return
    document.getElementById('character-full-body').style.display = 'block'
    document.getElementById('listener').src = `/assets/images/characters/${dialogue['display_character']}/${dialogue['display_character']}.png`
}

document.getElementById('btn-dialogue').addEventListener('click', nextDialogue)

function nextDialogue() {
    currentDialogueIndex++
    if (currentDialogueIndex < dialogues.length) {
        showDialogue(dialogues[currentDialogueIndex])
    } else {
        window.location.href = `/games/${game}`
    }
}

function buildText(element, text) {
    element.textContent = ''
    let lines = text.split('<br>')
    lines.forEach((line, index) => {
        element.appendChild(document.createTextNode(line))
        if (index !== lines.length - 1) {
            element.appendChild(document.createElement('br'))
        }
    })
}
