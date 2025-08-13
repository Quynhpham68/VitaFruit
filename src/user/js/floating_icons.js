const foodIcons = [
  "🍎", "🍌", "🍊", "🍉", "🍇", "🍍", "🍒", "🥝", "🍓",
  "🥑", "🥭", "🍅", "🥬", "🥦", "🥕", "🌽", "🧄", "🧅"
];

function createFloatingIcon() {
  const icon = document.createElement("div");
  icon.classList.add("floating-icon");
  icon.textContent = foodIcons[Math.floor(Math.random() * foodIcons.length)];
  icon.style.left = Math.random() * 100 + "vw";
  icon.style.top = "100vh";
  icon.style.fontSize = (Math.random() * 20 + 20) + "px";
  icon.style.animationDuration = (Math.random() * 10 + 15) + "s";
  document.body.appendChild(icon);

  setTimeout(() => icon.remove(), 25000);
}

setInterval(createFloatingIcon, 600);
