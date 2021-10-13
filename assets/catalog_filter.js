window.onload = () =>{
    let currentUrl = window.location.href;
    let domainName = window.location.origin

    // SEARCH BY TYPE
    let elem = document.querySelector('.book-items');
    let iso = new Isotope( elem, {
        itemSelector: '.book-item',
        layoutMode: 'fitRows'
    });

    let select = document.querySelector('.type-filter');

    select.addEventListener('change',(event)=>{

        let testValue = event.target;
        testValue = testValue.options[testValue.selectedIndex].getAttribute('data-filter');
        iso.arrange({ filter: testValue });
    })


    //SEARCH BY TITLE
    const textInput = document.querySelector('.search-catalog');
    textInput.addEventListener('keyup', debounce(function(e){
        onKeyUpSearch(e)
    }, 800))

    //FUNCTION ON KEYUP
    function onKeyUpSearch(e){
        let value = e.target.value;
        let url = '/catalogue/search/'+value+'/';

        if (value){
            axios.get(url).then ( (response) =>{

                if(response.data.bookFound.length > 0){

                    let bookId = response.data.bookFound[0].id;
                    let bookTitle = response.data.bookFound[0].title;
                    let bookAuthor = response.data.bookFound[0].author;
                    let bookCover = response.data.bookFound[0].imgCover;
                    let bookIsFavorite = response.data.bookFound[0].isFavorite;
                    let bookIsReserved = response.data.bookFound[0].isReserved;

                    displayBooks(bookId, bookTitle, bookAuthor, bookCover, bookIsFavorite, bookIsReserved, value);
                }else{
                    displayNotFound(value)
                }

            }).catch(function(error){
                console.log(error)
            })
        }else{
            document.getElementById('search-section').style.display = "none";
        }
    }

    function displayNotFound(value){
        const player = document.querySelector("lottie-player");
        document.getElementById('resultsTitle').innerText = 'Aucun résultat pour : '+value;

        document.getElementById('search-section').style.display = "flex";
        document.getElementById('bookFound').style.display = "none";
        document.getElementById('lottie-animation').style.display = "block";

        player.load("https://assets9.lottiefiles.com/packages/lf20_i1lnx7zw.json");

    }

    function displayBooks(bookId, bookTitle, bookAuthor, bookCover, bookIsFavorite, bookIsReserved,value){

        document.getElementById('search-section').style.display = "flex";
        document.getElementById('bookFound').style.display = "block";
        document.getElementById('lottie-animation').style.display = "none";
        document.getElementById('resultsTitle').innerText = 'Résultat de la recherche : '+value;

        let bookFoundIsFavorite = document.getElementById('bookFoundIsFavorite');
        let bookFoundIsReserve = document.getElementById('bookFoundIsReserved');

        document.getElementById('search-section').style.display = "flex";
        document.getElementById('bookFound').href = currentUrl+'livre/'+bookId;
        document.getElementById('bookFoundTitle').innerText = bookTitle;
        document.getElementById('bookFoundAuthor').innerText = bookAuthor;
        document.getElementById('bookFoundCover').src = domainName+'/images/covers/'+bookCover

        bookIsFavorite ? bookFoundIsFavorite.style.display = "block" : bookFoundIsFavorite.style.display = "none" ;
        bookIsReserved ? bookFoundIsReserve.style.display = "block" : bookFoundIsReserve.style.display = "none" ;

    }


    //DEBOUNCE FUNCTION
    function debounce(callback, delay){
        let timer;
        return function(){
            let args = arguments;
            let context = this;
            clearTimeout(timer);
            timer = setTimeout(function(){
                callback.apply(context, args);
            }, delay)
        }
    }
}