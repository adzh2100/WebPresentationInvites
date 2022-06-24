const userData = localStorage.getItem("user");
const user = JSON.parse(userData);

const guest = user.role === "guest";
const imageFileInput = document.getElementById("imageFileInput");
const topText = document.getElementById("topText");
const bottomText = document.getElementById("bottomText");
const canvas = document.getElementById("meme");

const btnDownload = document.getElementById("saveMeme");
const cpyImgBtn = document.getElementById("copyClipboard");
let memeURL;

let image;

if (guest == true) {
  let btn1 = document.getElementById("self-generate-btn");
  let btn2 = document.getElementById("auto-generate-btn");

  btn1.classList.add("hidden");
  btn2.classList.add("hidden");
}

if (user.role !== "teacher") {
  document.getElementById("stats").classList.add("hidden");
}

btnDownload.addEventListener("click", () => {
  const link = document.createElement("a");
  link.href = memeURL;
  link.download = "generatedMeme";
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
});

function imageToBlob(imageURL) {
  const img = new Image();
  const c = document.createElement("canvas");
  const ctx = c.getContext("2d");
  img.crossOrigin = "";
  img.src = imageURL;
  return new Promise((resolve) => {
    img.onload = function () {
      c.width = this.naturalWidth;
      c.height = this.naturalHeight;
      ctx.drawImage(this, 0, 0);
      c.toBlob(
        (blob) => {
          resolve(blob);
        },
        "image/png",
        0.75
      );
    };
  });
}

cpyImgBtn.addEventListener("click", async () => {
  const blob = await imageToBlob(memeURL);
  const item = new ClipboardItem({ "image/png": blob });
  navigator.clipboard.write([item]);
});

imageFileInput.addEventListener("change", () => {
  const imageDataUrl = URL.createObjectURL(imageFileInput.files[0]);

  image = new Image();
  image.src = imageDataUrl;

  image.addEventListener(
    "load",
    () => {
      updateMemeCanvas(canvas, image, topText.value, bottomText.value);
    },
    { once: true }
  );
});

topText.addEventListener("change", () => {
  updateMemeCanvas(canvas, image, topText.value, bottomText.value);
});

bottomText.addEventListener("change", () => {
  updateMemeCanvas(canvas, image, topText.value, bottomText.value);
});

function updateMemeCanvas(canvas, image, topText, bottomText) {
  const ctx = canvas.getContext("2d");
  const width = image.width;
  const height = image.height;

  const fontSize = Math.floor(width / 10);
  const yOffset = height / 25;

  //Update canvas background
  canvas.width = width;
  canvas.height = height;

  ctx.drawImage(image, 0, 0);

  // Prepare text
  ctx.strokeStyle = "black";
  ctx.lineWidth = Math.floor(fontSize / 4);
  ctx.fillStyle = "white";
  ctx.textAlign = "center";
  ctx.lineJoin = "round";
  ctx.font = `${fontSize}px sans-serif`;

  // Add top text
  ctx.textBaseline = "top";

  const wrappedText = wrapText(
    ctx,
    topText,
    width / 2,
    yOffset,
    width,
    fontSize
  );

  wrappedText.forEach(([text, x, y]) => {
    ctx.strokeText(text, x, y);
    ctx.fillText(text, x, y);
  });

  //add bottom text
  ctx.textBaseline = "bottom";

  const wrappedTextBottom = wrapText(
    ctx,
    bottomText,
    width / 2,
    yOffset,
    width,
    fontSize
  );

  wrappedTextBottom.forEach(([text, x, y], index) => {
    ctx.strokeText(
      text,
      x,
      height - wrappedTextBottom[wrappedTextBottom.length - index - 1][2]
    );
    ctx.fillText(
      text,
      x,
      height - wrappedTextBottom[wrappedTextBottom.length - index - 1][2]
    );
  });

  memeURL = canvas.toDataURL("image/png");
}

document
  .getElementById("self-generate-btn")
  .addEventListener("click", (event) => {
    event.preventDefault();

    if (
      !document.getElementById("auto-generated").classList.contains("hidden")
    ) {
      document.getElementById("auto-generated").classList.add("hidden");
      document.getElementById("autogenerated-meme").innerHTML = "";
    }

    if (
      document.getElementById("meme-generator").classList.contains("hidden")
    ) {
      document.getElementById("meme-generator").classList.remove("hidden");
    }
  });

document
  .getElementById("auto-generate-btn")
  .addEventListener("click", (event) => {
    event.preventDefault();
    document.getElementById("meme").innerHTML = "";

    if (
      document.getElementById("auto-generated").classList.contains("hidden")
    ) {
      document.getElementById("auto-generated").classList.remove("hidden");
    }

    if (
      !document.getElementById("meme-generator").classList.contains("hidden")
    ) {
      document.getElementById("meme-generator").classList.add("hidden");
    }

    generateInvite();
  });

function generateInvite() {
  const availableImages = 5;
  const invitationText = generateText();
  const autoGenerated = document.getElementById("auto-generated");
  const canvas = document.getElementById("autogenerated-meme");
  image = new Image();
  image.src = `templates/${Math.floor(
    ((Math.random() * 10) % availableImages) + 1
  )}.jpg`;

  const ctx = canvas.getContext("2d");

  image.addEventListener(
    "load",
    () => updateMemeCanvas(canvas, image, "", invitationText),
    { once: true }
  );
  autoGenerated.appendChild(canvas);
}

function generateText() {
  const { theme, presentationDate, presentationTime, facultyNumber } =
    getFormData();

  return `Здравейте! Каня ви на презентацията на ${user.first_name} ${user.last_name} с ФН: ${facultyNumber} на ${presentationDate} от ${presentationTime} на тема ${theme}`;
}

function getFormData() {
  return {
    theme: document.getElementById("theme").value,
    presentationDate: document.getElementById("presentation-date").value,
    presentationTime: document.getElementById("presentation-time").value,
    facultyNumber: document.getElementById("faculty-number").value,
    description: document.getElementById("description").value,
  };
}

const wrapText = function (ctx, text, x, y, maxWidth, lineHeight) {
  let words = text.split(" ");
  let line = "";
  let testLine = "";
  let lineArray = [];

  for (var n = 0; n < words.length; n++) {
    testLine += `${words[n]} `;
    let metrics = ctx.measureText(testLine);
    let testWidth = metrics.width;

    if (testWidth > maxWidth && n > 0) {
      lineArray.push([line, x, y]);
      y += lineHeight;
      line = `${words[n]} `;
      testLine = `${words[n]} `;
    } else {
      line += `${words[n]} `;
    }
    if (n === words.length - 1) {
      lineArray.push([line, x, y]);
    }
  }
  return lineArray;
};
