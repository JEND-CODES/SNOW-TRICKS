// Voir Mozilla : https://developer.mozilla.org/fr/docs/Apprendre/HTML/Comment/Utiliser_attributs_donnes


// Pour afficher un message avant la suppression des articles ????

const articles = document.getElementById('articles');


/*
if (articles) {
  articles.addEventListener('click', e => {
    alert(2);
  });
}
*/


if (articles) {
  articles.addEventListener('click', e => {
    if (e.target.className === 'btn btn-danger delete-article') {
        
      //if (confirm('Validez-vous ce choix ?')) {
        
        const id = e.target.getAttribute('data-id');

        fetch(`/snow_tricks_v2/public/index.php/article/delete/${id}`, {
          method: 'DELETE'
        }).then(res => window.location.reload());
        
      //}
        
    }
  });
}
/*
const chapters = document.getElementById('chapters');

if (chapters) {
  chapters.addEventListener('click', e => {
    if (e.target.className === 'suppress-post') {
        
      //if (confirm('OK ?')) {
        
        const id = e.target.getAttribute('suppress-id');

        fetch(`/symfovue16/public/index.php/office/delete/${id}`, {
          method: 'DELETE'
        }).then(res => window.location.reload());
        
      //}
        
    }
  });
}
*/
/*
const commentaires = document.getElementById('commentaires');

if (commentaires) {
  commentaires.addEventListener('click', e => {
    
      if (e.target.className === 'trash-comment') {
        
      //if (confirm('OK ?')) {
        
        const id = e.target.getAttribute('trash-id');

        fetch(`/symfovue16/public/index.php/backcom/delete/${id}`, {
          method: 'DELETE'
        }).then(res => window.location.assign("http://localhost/symfovue16/public/index.php/backcom"));
        
      //}
        
    }
      if (e.target.className === 'trash-test') {
   
        if (confirm('Trash test location ?')) {
       window.location.assign("http://localhost/symfovue16/public/index.php/backcom");
        
      }
        
    }
  });
}
*/