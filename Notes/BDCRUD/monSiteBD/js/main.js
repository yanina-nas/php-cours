document.addEventListener('DOMContentLoaded', addLikeListenersToAllButtons, false);
document.addEventListener('DOMContentLoaded', initLikeButtonClasses, false);

function initLikeButtonClasses() {
    const likeButtons = document.getElementsByClassName("likeButton");


    (function () {
        let xhr = [], i;
        for (let i = 0; i < likeButtons.length; i++) {
            (function (i) {
                xhr[i] = new XMLHttpRequest();
                xhr[i].onreadystatechange = () => {
                    if (xhr[i].readyState === XMLHttpRequest.DONE) {
                        const status = xhr[i].status;
                        if (status === 0 || (status >= 200 && status < 400)) {
                            console.log(xhr[i].responseText);
                            let reponse = JSON.parse(xhr[i].responseText);
                            if (reponse.erreurs.length > 0) {
                                return;
                            }
                            else {
                                let arrayLikes = reponse.donnees;
                                console.log('arrayLikes', arrayLikes);
                                if (arrayLikes.length > 0) {
                                    likeButtons[i].classList.add("rempli");
                                }
                            }
                        }
                        else {
                            console.log("erreur: " + xhr[i].status);
                        }
                    }
                };

                xhr[i].open("GET", `./verifyLike.php?id=${likeButtons[i].id}`);
                xhr[i].send();
            })(i);
        }
    })();

}

function addLikeListenersToAllButtons() {
    const likeButtons = document.getElementsByClassName("likeButton");

    for (likeButton of likeButtons) {

        likeButton.addEventListener("click", (event) => {
            let filmId = event.target.id;

            console.log(filmId);
            let xhr = new XMLHttpRequest();

            xhr.onreadystatechange = (event) => {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200 || xhr.status === 304) {

                        let reponse = JSON.parse(xhr.responseText);
                        console.log(reponse);
                        if (reponse.erreurs.length > 0) {
                            return;
                        }
                        else {
                            let arrayLikes = reponse.donnees;
                            afficheResultat(arrayLikes);
                        }
                    }
                    else {
                        console.log("erreur: " + xhr.status);
                    }
                }
            };

            xhr.open("GET", `./verifyLike.php?id=${filmId}`);
            xhr.send();
        }
        )
    }
}