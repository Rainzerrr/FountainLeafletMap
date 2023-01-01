$hambMenu = $('.hamb-menu')
$identification = $('.icon'); // lien vers l'identification du user


// Click sur le menu hamburger qui ouvre le vollet des rubriques

$hambMenu.on("click", function () {
    $rubriques.toggleClass("left");
});


// Click sur le lien vers l'identification du user

$identification.on("click", function () {
    window.location.href = 'ident.php';
})