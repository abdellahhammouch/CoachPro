// Tag Input for Disciplines
const choices = document.querySelectorAll(".choice");
const tagsContainer = document.getElementById("tags");
const hiddenInput = document.getElementById("hiddenInput");

let selected = [];

choices.forEach(choice => {
  choice.addEventListener("click", () => {
    const value = choice.dataset.value;

    // If already selected, don't add again
    if (selected.includes(value)) return;

    // Add to selected array
    selected.push(value);
    updateInput();

    // Create tag element
    const tag = document.createElement("div");
    tag.className = "tag";
    tag.innerHTML = `
      ${value}
      <button type="button">&times;</button>
    `;

    // Remove tag on click
    tag.querySelector("button").addEventListener("click", () => {
      selected = selected.filter(v => v !== value);
      tag.remove();
      updateInput();
    });

    tagsContainer.appendChild(tag);
  });
});

function updateInput() {
  hiddenInput.value = selected.join(",");
}