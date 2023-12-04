import MusicComponent from './musicComponent.js';

export default function CardContainer(title, musicDataArray, iconMusic, sectionName) {
    const cardContainer = document.createElement('div');
    cardContainer.className = 'card_container';
    cardContainer.id = sectionName;

    const titleContainer = document.createElement('div');
    titleContainer.className = 'title_container';
    titleContainer.innerHTML = `
        <p>${title} ${iconMusic}</p>
        <div class="chevron_container">
            <i class="fa-solid fa-chevron-left chev_icon"></i>
            <i class="fa-solid fa-chevron-right chev_icon"></i>
        </div>
    `;
    cardContainer.appendChild(titleContainer);

    const musicCardContainer = document.createElement('div');
    musicCardContainer.className = 'music_card_container';
    cardContainer.appendChild(musicCardContainer);

    for (let i = 0; i < musicDataArray.length; i++) {
        const musicComponent = MusicComponent(musicDataArray[i]);
        musicCardContainer.appendChild(musicComponent);
    }

    const showAllContainer = document.createElement('div');
    showAllContainer.className = 'showall_container';
    showAllContainer.innerHTML = '<p>Show All</p>';
    cardContainer.appendChild(showAllContainer);

    return cardContainer;
}


  