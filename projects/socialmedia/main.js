class CardLoader {
    constructor(containerId, batchSize) {
        this.container = document.getElementById(containerId);
        this.data = [];
        this.currentIndex = 0;
        this.batchSize = batchSize;
    }

    loadData(jsonUrl) {
        fetch(jsonUrl)
            .then(response => response.json())
            .then(data => {
                this.data = data;
                this.loadMoreCards();
                this.observeScroll();
            })
            .catch(error => {
                console.error('Error met het verkrijgen van de data ', error);
            });
    }

    loadMoreCards() {
        for (let i = 0; i < this.batchSize; i++) {
            if (this.currentIndex < this.data.length) {
                const item = this.data[this.currentIndex];
                const card = this.createCardElement();
                this.container.appendChild(card);
                this.createCard(card, item);
                this.currentIndex++;
            }
        }
    }

    observeScroll() {
        window.addEventListener('scroll', () => {
            if (window.innerHeight + window.scrollY >= document.body.offsetHeight) {
                this.loadMoreCards();
            }
        });
    }

    createCardElement() {
        return document.createElement('li');
    }
}

class CustomCardLoader extends CardLoader {
    constructor(containerId, batchSize) {
        super(containerId, batchSize);
    }

    createCardElement() {
        const card = super.createCardElement();
        card.setAttribute('class', 'content_card');
        return card;
    }

    createCard(cardElement, item) {
        cardElement.innerHTML = `
            <li class="content_card">
                <div class="content_infocontainer">
                    <div class="content_info">
                        <div class="content_infoimgcontainer">
                            <img class="content_infoimg" src="${item.img}" alt="">
                        </div>
                        <p class="content_infoaccountname">${item.username}</p>
                        <p class="content_infotimeadded">${item.timeposted}</p>
                    </div>
                    <div class="content_infooptions">
                        <i class="fa-solid fa-ellipsis content_infooptionicon"></i>
                    </div>
                </div>
                <div class="content_imgcontainer">
                    <img class="content_img" src="${item.content_img}" alt="">
                </div>
                <div class="content_ctacontainer">
                    <div class="content_calltoactions">
                        <i class="fa-solid fa-heart content_hearticon"></i>
                        <i class="fa-regular fa-comment content_commenticon"></i>
                        <i class="fa-regular fa-paper-plane content_shareicon"></i>
                    </div>
                    <div class="content_bookmarkcontainer">
                        <i class="fa-regular fa-bookmark content_bookmarkicon"></i>
                    </div>
                </div>
                <div class="content_likescontainer">
                    <p class="content_likesamount">${item.likes}</p>
                    <p class="content_likestext">likes</p>
                </div>
                <div class="content_commentcontainer">
                    <p class="content_commentaccount">${item.username} :</p>
                    <p class="content_comment">${item.comment}</p>
                </div>
            </li>
        `;
    }
}

document.addEventListener("DOMContentLoaded", function () {
    const customCardLoader = new CustomCardLoader('cardContainer', 2);
    customCardLoader.loadData('information.json');
});