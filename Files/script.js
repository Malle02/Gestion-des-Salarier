



document.addEventListener("DOMContentLoaded", function() {
  const searchInput = document.querySelector(".search");
  const searchResults = document.getElementById("searchResults");
  let cachedQuery = ""; // Variable pour stocker la valeur de recherche précédente

  searchInput.addEventListener("input", function() {
    const searchValue = searchInput.value.toLowerCase();

    if (searchValue === "") {
      searchResults.innerHTML = "";
      searchResults.style.display = "none";
      return;
    }

    const searchItems = Array.from(document.querySelectorAll(".salaries li"));
    const matchingItems = searchItems.filter(function(item) {
      const name = item.textContent.toLowerCase();
      return name.includes(searchValue);
    });

    searchResults.innerHTML = "";
    if (matchingItems.length > 0) {
      matchingItems.forEach(function(item) {
        searchResults.appendChild(item.cloneNode(true));
      });
      searchResults.style.display = "block";
    } else {
      searchResults.style.display = "none";
    }

    cachedQuery = searchValue; // Mise à jour de la valeur de recherche mise en cache
  });

  const searchForm = document.querySelector(".search-bar form");
  searchForm.addEventListener("submit", function(event) {
    event.preventDefault(); // Empêche le rechargement de la page

    const query = searchInput.value.toLowerCase();
    const allItems = Array.from(document.querySelectorAll(".salaries li"));
    const matchingItems = allItems.filter(function(item) {
      const name = item.textContent.toLowerCase();
      return name.includes(query);
    });

    searchResults.innerHTML = "";
    if (matchingItems.length > 0) {
      matchingItems.forEach(function(item) {
        searchResults.appendChild(item.cloneNode(true));
      });
      searchResults.style.display = "block";
    } else {
      searchResults.style.display = "none";
      searchResults.innerHTML = "<p>Aucun salarié trouvé.</p>";
    }

    cachedQuery = query; // Mise à jour de la valeur de recherche mise en cache
  });

  // Restaurer la valeur de recherche à partir du cache lors du chargement de la page
  if (cachedQuery !== "") {
    searchInput.value = cachedQuery;
  }
});
