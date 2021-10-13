/*

const BDDJSON= "../BDD/BDD.json"; // permet d'acceder a la base de donnee
const TESTJSON= "../compte/TEST.json"; // permet d'acceder a la base de donnee


// lecture de Json v2
let getData=(url, cb)=>{ // lecture de BDD
  fetch(url)
    .then(response => response.json())
    .then(result => cb(result))
}
//

let putData=(url, BDD)=>{ // ecriture de BDD

  try{
    
  const myInit = { // parametre de fetch
    method: 'post',
    body: JSON.stringify({BDD})
  };

  fetch(url, myInit) // ecriture de BDD
    .then(res => res.json())
    .then(res => console.log(res))
  } catch (error){
    console.error(error);
  }
}

// --------------------------------------------------------

getData(BDDJSON, (BDD) => console.log(BDD.creaClient)) // Permet l'écriture du client


let newClient = JSON.stringify(creaClient);
let creatClient = JSON.parse(newClient);
console.log(creaClient)

/* Traduction en javascript c'est l'utilisation d'objet prédefini !!!!

let client = [{
    nom : "Exemple : Dupont" ,
    prenom : "Exemple : Jacques" ,
    dateDeNaiss : "Votre date de naissance en format JJ/MM/AAAA : ",
    sexe : "Homme || Femme",
    adresse : "Exemple : 20 rue du Temple",
    ville : "Exemple : Paris",
    codePost : "Exemple : 75000",
    telPort : "Exemple : 06.01.01.01.01",
    telFixe : "Exemple : 01.45.02.02.02",
    mail : "Exemple : exemple@exe.com",
}];

let creaClient = [{
    nom : prompt("Votre nom : ") ,
    prenom : prompt("Votre prénom : ") ,
    dateDeNaiss : prompt("Votre date de naissance type JJ/MM/AAAA : ") ,
    sexe : prompt(" Femme ou Homme : ") ,
    adresse : prompt("Votre adresse (numéro + rue) : ") ,
    ville : prompt("Votre ville : ") ,
    codePost : prompt("Votre code Postale : ") ,
    telPort : prompt("Votre numéro de portable (06.01.01.01.01) : ") ,
    telFixe : prompt("Votre numéro fixe (02.01.01.01.01) : ") ,
    mail : prompt("Votre mail (exemple@exe.com) : ") ,
}];

*/
/*
WebSocket WebSocket(
  in DOMString url,
  in optional DOMString protocols
);

WebSocket WebSocket(
  in DOMString url,
  in optional DOMString[] protocols
);

*/ 


// Envoi d'un texte à tous les utilisateurs à travers le serveur
function sendText() {
  // Création d'un objet msg qui contient les données
  // dont le serveur a besoin pour traiter le message
  var msg = {
    type: "message",
    text: document.getElementById("text").value,
    id:   clientID,
    date: Date.now()
  };

  // Envoi de l'objet msg à travers une chaîne formatée en JSON
  exampleSocket.send(JSON.stringify(msg));

  // Efface le texte de l'élément input
  // afin de recevoir la prochaine ligne de texte
  // que l'utilisateur va saisir
  document.getElementById("text").value = "";
}

let exampleSocket = new WebSocket("ws://www.example.com/socketserver", ["protocolOne", "protocolTwo"]);

exampleSocket.onmessage = function(event) {
  let f = document.getElementById("chatbox").contentDocument;
  let text = "";
  let msg = JSON.parse(event.data);
  let time = new Date(msg.date);
  let timeStr = time.toLocaleTimeString();

  switch(msg.type) {
    case "id":
      clientID = msg.id;
      setUsername();
      break;
    case "username":
      text = "<b>User <em>" + msg.nom + "</em> signed in at " + timeStr + "</b><br>";
      break;
    case "message":
      text = "(" + timeStr + ") <b>" + msg.nom + "</b>: " + msg.text + "<br>";
      break;
    case "rejectusername":
      text = "<b>Votre nom est déjà utiliser <em>" + msg.nom + "</em> choissisez un autre nom.</b><br>"
      break;
    case "userlist":
      var ul = "";
      for (i=0; i < msg.users.length; i++) {
        ul += msg.users[i] + "<br>";
      }
      document.getElementById("userlistbox").innerHTML = ul;
      break;
  }

  if (text.length) {
    f.write(text);
    document.getElementById("chatbox").contentWindow.scrollByPages(1);
  }
};
