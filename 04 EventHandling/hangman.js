
let ratewort = worte[Math.floor( Math.random() * worte.length )]
let fehler = 0
//console.log(ratewort)
let anzeigewort = ''
for (let i = 0; i < ratewort.length; i++) {
  anzeigewort += '_'
}
document.getElementById('ausgabe').innerHTML = anzeigewort

document.addEventListener('keydown', function (evt) {
  let taste = evt.key.toUpperCase()
  if (taste.charCodeAt(0) > 64 && taste.charCodeAt(0) < 91) {
    document.getElementById('info').innerHTML = ''

    let gefunden = false
    for (let i = 0; i < ratewort.length; i++) {
      if (ratewort[i].toUpperCase() === taste) {
        anzeigewort = anzeigewort.slice(0,i) + taste + anzeigewort.slice(i + 1)
        gefunden = true
      } 
    }
    if (gefunden) {
      document.getElementById('ausgabe').innerHTML = anzeigewort
      if (anzeigewort === ratewort.toUpperCase()) {
        document.getElementById('info').innerHTML = 'Du hast gewonnen.<p><a href="07_ÜbungHangman.html">Spiel neu starten</a>'
      }
    } else {
      if (fehler < 7) fehler++
      document.getElementById('hmpic').src = 'mats/hm' + fehler + '.jpg'
      if (fehler === 7) {
        document.getElementById('ausgabe').innerHTML = 'Du bist tot'
        document.getElementById('info').innerHTML = 'Du hast verloren.'
      }
    }
  } else {
    document.getElementById('info').innerHTML = 'Es wurde eine ungültige Taste gedrückt.'
  }
}) 
