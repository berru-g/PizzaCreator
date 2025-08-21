document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('pizza-canvas');
    const ctx = canvas.getContext('2d');
    const ingredientItems = document.querySelectorAll('.ingredient-item');
    const selectedIngredientsContainer = document.getElementById('selected-ingredients');
    const totalPriceElement = document.getElementById('total-price');
    const resetBtn = document.getElementById('reset-btn');
    const orderForm = document.getElementById('order-form');
    const ingredientsInput = document.getElementById('ingredients-input');
    const totalPriceInput = document.getElementById('total-price-input');
    const customAlert = document.getElementById('custom-alert');
    const tableNumberElement = document.getElementById('table-number');
    const tableIdInput = document.getElementById('table-id-input');

    let selectedIngredients = [];
    let basePrice = 8.50;
    let totalPrice = basePrice;

    // Récupérer l'ID de la table depuis l'URL
    function getTableIdFromURL() {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get('table_id') || '1';
    }

    function updateTableDisplay() {
        const tableId = getTableIdFromURL();
        tableNumberElement.textContent = `#${tableId}`;
        tableIdInput.value = tableId;
    }

    updateTableDisplay();

    // Positions prédéfinies pour chaque type d'ingrédient
    const ingredientPositions = {
        'Mozzarella': [
            { x: 0, y: 0, size: 20 },
            { x: 0.3, y: 0.3, size: 20 },
            { x: -0.3, y: -0.3, size: 20 },
            { x: 0.4, y: -0.2, size: 20 },
            { x: -0.4, y: 0.2, size: 20 }
        ],
        'Chèvre': [
            { x: -0.2, y: 0.3, size: 15 },
            { x: 0.2, y: -0.3, size: 15 },
            { x: 0.3, y: 0.1, size: 15 }
        ],
        'Emmental': [
            { x: 0.1, y: 0.3, size: 18 },
            { x: -0.1, y: -0.3, size: 18 },
            { x: -0.3, y: 0.1, size: 18 }
        ],
        'Bleu': [
            { x: 0.2, y: 0.2, size: 12 },
            { x: -0.2, y: -0.2, size: 12 },
            { x: 0, y: 0, size: 12 }
        ],
        'Jambon': [
            { x: 0.2, y: 0.1, size: 25 },
            { x: -0.2, y: -0.1, size: 25 },
            { x: 0.1, y: -0.2, size: 25 }
        ],
        'Pepperoni': [
            { x: 0.3, y: 0.2, size: 18 },
            { x: -0.3, y: -0.2, size: 18 },
            { x: 0.2, y: -0.3, size: 18 },
            { x: -0.2, y: 0.3, size: 18 },
            { x: 0, y: 0.4, size: 18 }
        ],
        'Poulet': [
            { x: 0, y: 0.2, size: 22 },
            { x: -0.1, y: -0.2, size: 22 },
            { x: 0.3, y: 0, size: 22 }
        ],
        'Bœuf': [
            { x: 0.2, y: 0.25, size: 20 },
            { x: -0.2, y: -0.25, size: 20 },
            { x: 0.25, y: -0.1, size: 20 }
        ],
        'Champignons': [
            { x: 0.15, y: 0.35, size: 16 },
            { x: -0.15, y: -0.35, size: 16 },
            { x: 0.35, y: -0.15, size: 16 },
            { x: -0.35, y: 0.15, size: 16 }
        ],
        'Olives': [
            { x: 0.25, y: 0.15, size: 10 },
            { x: -0.25, y: -0.15, size: 10 },
            { x: 0.15, y: -0.25, size: 10 },
            { x: -0.15, y: 0.25, size: 10 },
            { x: 0.3, y: 0.3, size: 10 }
        ],
        'Poivrons': [
            { x: 0.2, y: 0.3, size: 14 },
            { x: -0.2, y: -0.3, size: 14 },
            { x: 0.3, y: -0.1, size: 14 },
            { x: -0.3, y: 0.1, size: 14 }
        ],
        'Oignons': [
            { x: 0.1, y: 0.25, size: 12 },
            { x: -0.1, y: -0.25, size: 12 },
            { x: 0.25, y: 0, size: 12 },
            { x: -0.25, y: 0, size: 12 },
            { x: 0, y: 0.3, size: 12 },
            { x: 0, y: -0.3, size: 12 }
        ]
    };

    // Fonction pour afficher des alertes personnalisées
    function showAlert(message, type) {
        customAlert.textContent = message;
        customAlert.className = 'custom-alert alert-show';
        if (type === 'success') {
            customAlert.classList.add('alert-success');
        } else {
            customAlert.classList.add('alert-error');
        }

        setTimeout(() => {
            customAlert.classList.remove('alert-show');
            setTimeout(() => {
                customAlert.className = 'custom-alert';
            }, 400);
        }, 3000);
    }

    // Initialiser le canvas
    function initCanvas() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
    }

    // Dessiner un ingrédient sur la pizza à des positions spécifiques
    function drawIngredient(ingredient) {
        const centerX = canvas.width / 2;
        const centerY = canvas.height / 2;
        const radius = 150;

        const positions = ingredientPositions[ingredient.name] || [];

        positions.forEach(pos => {
            const x = centerX + pos.x * radius;
            const y = centerY + pos.y * radius;
            const size = pos.size;

            ctx.beginPath();

            // Dessiner différemment selon le type d'ingrédient
            if (ingredient.name === 'Pepperoni') {
                ctx.fillStyle = ingredient.color || '#cc0000';
                ctx.arc(x, y, size, 0, Math.PI * 2);
            } else if (ingredient.name === 'Olives') {
                ctx.fillStyle = ingredient.color || '#36454F';
                ctx.arc(x, y, size, 0, Math.PI * 2);
            } else if (ingredient.name === 'Oignons') {
                ctx.fillStyle = ingredient.color || '#dda0dd';
                ctx.arc(x, y, size, 0, Math.PI * 2);
            } else if (ingredient.name === 'Champignons') {
                ctx.fillStyle = ingredient.color || '#d2b48c';
                // Dessiner un champignon (cercle + tige)
                ctx.arc(x, y, size, 0, Math.PI * 2);
                ctx.fill();
                ctx.fillStyle = '#f5f5dc';
                ctx.fillRect(x - size / 3, y, size * 0.66, size);
            } else if (ingredient.name === 'Jambon' || ingredient.name === 'Poulet' || ingredient.name === 'Bœuf') {
                ctx.fillStyle = ingredient.color || '#ffcccb';
                // Dessiner une forme irrégulière pour la viande
                ctx.beginPath();
                ctx.moveTo(x, y - size);
                ctx.lineTo(x + size, y);
                ctx.lineTo(x, y + size);
                ctx.lineTo(x - size, y);
                ctx.closePath();
            } else {
                // Fromages et autres ingrédients
                ctx.fillStyle = ingredient.color || '#f8f8f8';
                ctx.arc(x, y, size, 0, Math.PI * 2);
            }

            ctx.fill();
            ctx.closePath();
        });
    }

    // Mettre à jour l'affichage de la pizza
    function updatePizzaDisplay() {
        initCanvas();

        // Redessiner tous les ingrédients sélectionnés
        selectedIngredients.forEach(ingredient => {
            drawIngredient(ingredient);
        });
    }

    // Mettre à jour le récapitulatif des ingrédients
    function updateIngredientsSummary() {
        selectedIngredientsContainer.innerHTML = '';

        selectedIngredients.forEach(ingredient => {
            const ingElement = document.createElement('div');
            ingElement.className = 'selected-ingredient';
            ingElement.innerHTML = `
                        <img src="https://cdn-icons-png.flaticon.com/512/2590/2590245.png" alt="${ingredient.name}">
                        <span>${ingredient.name}</span>
                    `;
            selectedIngredientsContainer.appendChild(ingElement);
        });
    }

    // Mettre à jour le prix total
    function updateTotalPrice() {
        totalPrice = basePrice;
        selectedIngredients.forEach(ingredient => {
            totalPrice += ingredient.price;
        });

        totalPriceElement.textContent = totalPrice.toFixed(2);
        totalPriceInput.value = totalPrice.toFixed(2);
    }

    // Gérer la sélection d'ingrédients
    ingredientItems.forEach(item => {
        item.addEventListener('click', function () {
            const ingredientName = this.getAttribute('data-ingredient');
            const ingredientPrice = parseFloat(this.getAttribute('data-price'));
            const ingredientColor = this.getAttribute('data-color');

            // Vérifier si l'ingrédient est déjà sélectionné
            const existingIndex = selectedIngredients.findIndex(ing => ing.name === ingredientName);

            if (existingIndex === -1) {
                // Ajouter l'ingrédient
                selectedIngredients.push({
                    name: ingredientName,
                    price: ingredientPrice,
                    color: ingredientColor
                });
                this.classList.add('selected');
            } else {
                // Retirer l'ingrédient
                selectedIngredients.splice(existingIndex, 1);
                this.classList.remove('selected');
            }

            // Mettre à jour l'affichage
            updatePizzaDisplay();
            updateIngredientsSummary();
            updateTotalPrice();
        });
    });

    // Réinitialiser la sélection
    resetBtn.addEventListener('click', function () {
        selectedIngredients = [];
        ingredientItems.forEach(item => item.classList.remove('selected'));
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        selectedIngredientsContainer.innerHTML = '';
        totalPriceElement.textContent = basePrice.toFixed(2);
        totalPriceInput.value = basePrice.toFixed(2);
        showAlert('Votre pizza a été réinitialisée', 'success');
    });

    // Soumission
    orderForm.addEventListener('submit', async function (e) {
        e.preventDefault();

        if (selectedIngredients.length === 0) {
            showAlert('Veuillez sélectionner au moins un ingrédient.', 'error');
            return;
        }

        const ingredientsList = selectedIngredients.map(ing => ing.name).join(',');
        ingredientsInput.value = ingredientsList;

        try {
            const formData = new FormData(orderForm);
            const response = await fetch('submit.php', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();
            if (result.success) {
                showAlert('Commande envoyée à la cuisine !', 'success');
                setTimeout(() => location.reload(), 2000);
            } else {
                throw new Error(result.message || 'Erreur serveur');
            }
        } catch (error) {
            showAlert('Erreur: ' + error.message, 'error');
        }
    });
});