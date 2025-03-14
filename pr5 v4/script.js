const gallery = document.getElementById('gallery');
const refreshButton = document.getElementById('refreshButton');
const API_URL = 'https://picsum.photos/v2/list';
const CACHE_KEY = 'imageGallery';

function displayImages(images) {
    gallery.innerHTML = '';
    images.forEach(image => {
        const img = document.createElement('img');
        img.src = image.download_url;
        img.alt = image.author;
        gallery.appendChild(img);
    });
}

function fetchImages() {
    return fetch(API_URL)
        .then(response => response.json())
        .then(images => {
            localStorage.setItem(CACHE_KEY, JSON.stringify(images));
            return images;
        });
}

function loadImages() {
    const cachedImages = localStorage.getItem(CACHE_KEY);
    if (cachedImages) {
        displayImages(JSON.parse(cachedImages));
    } else {
        fetchImages().then(displayImages);
    }
}

refreshButton.addEventListener('click', () => {
    fetchImages().then(displayImages);
});

loadImages();