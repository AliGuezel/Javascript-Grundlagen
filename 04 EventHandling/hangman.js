let ratewort = worte[Math.floor( Math.random() * worte.length )]
console.log(ratewort)
let anzeigewort = ''
for (let i = 0; i < ratewort.length; i++) {
  anzeigewort += '_'
}
document.getElementById('ausgabe').innerHTML = anzeigewort

document.addEventListener('keydown', function (evt) {
  let taste = evt.key.toUpperCase()
  if (taste.charCodeAt(0) > 64 && taste.charCodeAt(0) < 91) {
    document.getElementById('info').innerHTML = ''

    for (let i = 0; i < ratewort.length; i++) {
      if (ratewort[i].toUpperCase()== taste) anzeigewort = anzeigewort.slice(0,i) + taste + anzeigewort.slice(i + 1)
    }
    document.getElementById('ausgabe').innerHTML = anzeigewort


  } else {
    document.getElementById('info').innerHTML = 'Es wurde eine ungültige Taste gedrückt.'
  }
}) 
