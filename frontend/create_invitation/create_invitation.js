if (!localStorage.getItem('user')) {
  location.href = '../login/login.html';
}

const imageFileInput = document.getElementById('imageFileInput');
const topText = document.getElementById('topText');
const bottomText = document.getElementById('bottomText');
const canvas = document.getElementById('meme');

let image;

imageFileInput.addEventListener('change', () => {
  const imageDataUrl = URL.createObjectURL(imageFileInput.files[0]);

  image = new Image();
  image.src = imageDataUrl;

  image.addEventListener(
    'load',
    () => {
      updateMemeCanvas(canvas, image, topText.value, bottomText.value);
    },
    { once: true }
  );
});

topText.addEventListener('change', () => {
  updateMemeCanvas(canvas, image, topText.value, bottomText.value);
});

bottomText.addEventListener('change', () => {
  updateMemeCanvas(canvas, image, topText.value, bottomText.value);
});

function updateMemeCanvas(canvas, image, topText, bottomText) {
  const ctx = canvas.getContext('2d');
  const width = image.width;
  const height = image.height;

  const fontSize = Math.floor(width / 10);
  const yOffset = height / 25;

  //Update canvas background
  canvas.width = width;
  canvas.height = height;

  ctx.drawImage(image, 0, 0);

  // Prepare text
  ctx.strokeStyle = 'black';
  ctx.lineWidth = Math.floor(fontSize / 4);
  ctx.fillStyle = 'white';
  ctx.textAlign = 'center';
  ctx.lineJoin = 'round';
  ctx.font = `${fontSize}px sans-serif`;

  // Add top text
  ctx.textBaseline = 'top';
  ctx.strokeText(topText, width / 2, yOffset);
  ctx.fillText(topText, width / 2, yOffset);

  //add bottom text
  ctx.textBaseline = 'bottom';
  ctx.strokeText(bottomText, width / 2, height - yOffset);
  ctx.fillText(bottomText, width / 2, height - yOffset);
}

document.getElementById('logout-btn').addEventListener('click', event => {
  event.preventDefault();

  logout().then(response => {
    if (response.success) {
      localStorage.removeItem('user');
      location.replace('../login/login.html');
    }
  });
});

async function logout() {
  const response = await fetch('../../backend/endpoints/logout.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
  });

  const result = await response.json();
  return result;
}
