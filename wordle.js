var word;

var height = 6; //number of guesses
var width; //length of the word

var row = 0; //current guess (attempt #)
var col = 0; //current letter for that attempt

var gameOver = false;

var guesses = 0; // Compteur de tentatives
const MAX_ATTEMPTS = 6; // Nombre maximum de tentatives


window.onload = function () {
    intialize();
}

var guessList = [
    // Fruits
    "pomme", "raisin", "citron", "mangue", "peche", "baies", "melon", "prune", "cerise", "banane",
    "orange", "figue", "datte", "goave", "kiwi", "poire", "lime", "papaye", "abricot", "litchi",
    "coing", "fraise", "framboise", "myrtille", "cassis", "groseille", "nectarine", "grenade", "pamplemousse",

    // Animaux
    "chien", "chat", "lapin", "souris", "tigre", "lion", "zebre", "cheval", "ane", "vache",
    "mouton", "chevre", "cochon", "elephant", "giraffe", "hippopotame", "rhinoceros", "pangolin",
    "loup", "renard", "ours", "panda", "koala", "singe", "serpent", "iguane", "caméléon", "dauphin",
    "requin", "baleine", "pieuvre", "crabe", "saumon", "thon", "truite", "pingouin", "aigle", "faucon",

    // Objets
    "chaise", "table", "lampe", "canape", "couteau", "fourchette", "cuillere", "verre", "assiette",
    "ordinateur", "ecran", "clavier", "souris", "telephone", "bouteille", "vase", "montre",
    "stylo", "crayon", "gomme", "livre", "cahier", "cartable", "sac", "lunettes", "parapluie",
    "chapeau", "couteau", "tasse", "brouette", "briquet", "balle", "boite", "voiture", "velo", "moto",

    // Vêtements
    "pantalon", "chemise", "veste", "manteau", "chaussure", "chapeau", "casquette", "foulard",
    "ceinture", "gilet", "pull", "chaussettes", "cravate", "jupe", "robe", "short", "bermuda",
    "blouson", "anorak", "impermeable", "bottes", "gants", "echarpe", "bonnet",

    // Couleurs
    "rouge", "bleu", "vert", "jaune", "orange", "violet", "rose", "blanc", "noir", "gris", "marron",
    "cyan", "magenta", "turquoise", "ocre", "beige", "azur",

    // Villes françaises
    "paris", "lyon", "marseille", "toulouse", "bordeaux", "lille", "nice", "nantes", "strasbourg",
    "rennes", "grenoble", "dijon", "angers", "clermont", "amiens", "nancy", "reims", "metz", "caen",
    "tours", "orléans", "mulhouse", "limoges", "besançon", "perpignan",

    // Pays
    "france", "allemagne", "italie", "espagne", "portugal", "belgique", "suisse", "autriche", "chine",
    "japon", "corée", "brésil", "argentine", "mexique", "canada", "etatsunis", "australie", "inde", "russie",
    "afrique", "egypte", "maroc", "tunisie", "algérie", "sénégal", "nigeria", "kenya", "tanzanie", "israel",

    // Technologies
    "internet", "ordinateur", "tablette", "smartphone", "bluetooth", "usb", "wifi", "android", "ios",
    "fibre", "serveur", "cloud", "logiciel", "materiel", "protocole", "navigateur", "reseau", "base", "donnees",
    "algorithme", "intelligence", "artificielle", "robot", "imprimante", "scanner", "microprocesseur", "carte",
    "graphique", "memoire", "disque", "ssd", "interface", "machine", "systeme", "programme",

    // Autres
    "soleil", "lune", "pluie", "neige", "vent", "orage", "nuage", "arc", "ciel", "terre", "mer",
    "ocean", "montagne", "foret", "desert", "riviere", "lac", "volcan", "plateau", "prairie",
    "village", "ville", "metropole", "quartier", "avenue", "boulevard", "rue", "rondpoint", "impasse", "passage"
];


function intialize() {

    word = document.getElementById("wordInput").value;

    console.log(word);


    width = word.length;


    // Create the game board
    for (let r = 0; r < height; r++) {
        let row = document.createElement("div");
        row.classList.add("row");
        row.id = r.toString() + "-" + "row";
        document.getElementById("board").appendChild(row);

        for (let c = 0; c < width; c++) {
            // <span id="0-0" class="tile">P</span>
            let col = document.createElement("div");
            col.classList.add("col");
            col.id = r.toString() + "-" + c.toString() +"-" + "col";
            document.getElementById(r.toString() + "-" + "row").appendChild(col);
            let tile = document.createElement("span");
            tile.id = r.toString() + "-" + c.toString();
            tile.classList.add("tile");
            tile.innerText = "";
            document.getElementById(r.toString() + "-" + c.toString() +"-" + "col").appendChild(tile);

        }
    }

    // Create the key board
    let keyboard = [
        ["Q", "W", "E", "R", "T", "Z", "U", "I", "O", "P"],
        ["A", "S", "D", "F", "G", "H", "J", "K", "L", " "],
        ["Enter", "Y", "X", "C", "V", "B", "N", "M", "⌫"]
    ]

    for (let i = 0; i < keyboard.length; i++) {
        let currRow = keyboard[i];
        let keyboardRow = document.createElement("div");
        keyboardRow.classList.add("keyboard-row");

        for (let j = 0; j < currRow.length; j++) {
            let keyTile = document.createElement("div");

            let key = currRow[j];
            keyTile.innerText = key;
            if (key == "Enter") {
                keyTile.id = "Enter";
            }
            else if (key == "⌫") {
                keyTile.id = "Backspace";
            }
            else if ("A" <= key && key <= "Z") {
                keyTile.id = "Key" + key; // "Key" + "A";
            }

            keyTile.addEventListener("click", processKey);

            if (key == "Enter") {
                keyTile.classList.add("enter-key-tile");
            } else {
                keyTile.classList.add("key-tile");
            }
            keyboardRow.appendChild(keyTile);
        }
        document.body.appendChild(keyboardRow);
        document.getElementById("keyboard").appendChild(keyboardRow);

    }


    // Listen for Key Press
    document.addEventListener("keyup", (e) => {
        let keyPressed = e.key;

        // Gestion des touches spéciales
        if (keyPressed === "Enter") {
            processInput({ code: "Enter" });
            return;
        } else if (keyPressed === "Backspace") {
            processInput({ code: "Backspace" });
            return;
        }

        // Corrige la correspondance des touches pour un clavier QWERTZ
        if (keyPressed === "Y") {
            keyPressed = "Z";
        } else if (keyPressed === "Z") {
            keyPressed = "Y";
        }

        // Recompose l'événement avec la touche corrigée
        let correctedEvent = { code: "Key" + keyPressed.toUpperCase() };
        processInput(correctedEvent);
    });
}

function processKey() {
    e = { "code": this.id };
    processInput(e);
}

function processInput(e) {
    if (gameOver) return;

    // alert(e.code);
    if ("KeyA" <= e.code && e.code <= "KeyZ") {
        if (col < width) {
            let currTile = document.getElementById(row.toString() + '-' + col.toString());
            if (currTile.innerText == "") {
                currTile.innerText = e.code[3];
                col += 1;
            }
        }
    }
    else if (e.code == "Backspace") {
        if (0 < col && col <= width) {
            col -= 1;
        }
        let currTile = document.getElementById(row.toString() + '-' + col.toString());
        currTile.innerText = "";
    }

    else if (e.code == "Enter") {
        update();
    }

    if (!gameOver && row == height) {
        gameOver = true;
        document.getElementById("answer").innerText = word;
    }
}

function update() {
    let guess = "";
    document.getElementById("answer").innerText = "";

    // String up the guesses into the word
    for (let c = 0; c < width; c++) {
        let currTile = document.getElementById(row.toString() + '-' + c.toString());
        let letter = currTile.innerText;
        guess += letter;
    }

    guess = guess.toLowerCase(); // case sensitive
    console.log(guess);

    if (!guessList.includes(guess)) {
        document.getElementById("answer").innerText = "Ce mot n'est pas reconnu";
        return;
    }

    // Start processing guess
    let correct = 0;

    let letterCount = {}; // Keep track of letter frequency
    for (let i = 0; i < word.length; i++) {
        let letter = word[i];

        if (letterCount[letter]) {
            letterCount[letter] += 1;
        } else {
            letterCount[letter] = 1;
        }
    }

    console.log(letterCount);

    // First iteration, check all the correct ones first
    for (let c = 0; c < width; c++) {
        let currTile = document.getElementById(row.toString() + '-' + c.toString());
        let letter = currTile.innerText;

        // Is it in the correct position?
        if (word[c] == letter) {
            currTile.classList.add("correct");

            let keyTile = document.getElementById("Key" + letter);
            keyTile.classList.remove("present");
            keyTile.classList.add("correct");

            correct += 1;
            letterCount[letter] -= 1; // Deduct the letter count
        }

        if (correct == width) {
            gameOver = true;
            guesses++; // Incrémente le compteur de tentatives
            sendGuesses(guesses); // Appelle la fonction pour envoyer les tentatives
        }
    }

    // Go again and mark which ones are present but in the wrong position
    for (let c = 0; c < width; c++) {
        let currTile = document.getElementById(row.toString() + '-' + c.toString());
        let letter = currTile.innerText;

        // Skip the letter if it has been marked correct
        if (!currTile.classList.contains("correct")) {
            // Is it in the word? 
            if (word.includes(letter) && letterCount[letter] > 0) {
                currTile.classList.add("present");

                let keyTile = document.getElementById("Key" + letter);
                if (!keyTile.classList.contains("correct")) {
                    keyTile.classList.add("present");
                }
                letterCount[letter] -= 1;
            } else {
                currTile.classList.add("absent");
                let keyTile = document.getElementById("Key" + letter);
                keyTile.classList.add("absent");
            }
        }
    }

    row += 1; // Start new row
    col = 0; // Start at 0 for new row
    guesses++; // Incrémente le compteur de tentatives

    // Vérifie si le jeu est terminé (soit par victoire, soit par épuisement des tentatives)
    if (gameOver || row >= MAX_ATTEMPTS) {
        gameOver = true;
        document.getElementById("answer").innerText = word;
        sendGuesses(guesses); // Appelle la fonction pour envoyer les tentatives
    }
}

function sendGuesses(guesses) {
    // Met à jour le champ caché avec le nombre de tentatives
    document.getElementById('guessesInput').value = guesses;

    // Soumet le formulaire pour envoyer les données à PHP
    document.getElementById('guessesForm').submit();
}

