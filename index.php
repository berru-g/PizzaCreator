<?php
// Récupérer l'ID de table depuis l'URL
$table_id = isset($_GET['table_id']) ? intval($_GET['table_id']) : 1;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PizzaCreator - Composez votre pizza</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="custom-alert" id="custom-alert"></div>
    
    <div class="container">
        <header>
            <h1>PizzaCreator</h1>
            <p>Composez votre pizza personnalisée en sélectionnant les ingrédients</p>
        </header>
        
        <div class="pizza-display">
            <h2>Votre Création</h2>
            <div class="pizza-canvas-container">
                <div id="pizza-base"></div>
                <canvas id="pizza-canvas" width="350" height="350"></canvas>
            </div>
            <div class="action-buttons">
                <button id="reset-btn" class="btn btn-danger">Tout effacer</button>
            </div>
        </div>
        
        <div class="ingredients-panel">
            <h2>Ingrédients</h2>
            
            <div class="ingredient-category">
                <h3>Fromages</h3>
                <div class="ingredients-grid">
                    <div class="ingredient-item" data-ingredient="Mozzarella" data-price="1.5" data-color="#f8f8f8">
                        <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI1MCIgaGVpZ2h0PSI1MCIgdmlld0JveD0iMCAwIDUwIDUwIj48Y2lyY2xlIGN4PSIyNSIgY3k9IjI1IiByPSIyMCIgZmlsbD0iI2Y4ZjhmOCIgc3Ryb2tlPSIjZGRkIiBzdHJva2Utd2lkdGg9IjIiLz48L3N2Zz4=" alt="Mozzarella" class="ingredient-icon">
                        <span>Mozzarella</span>
                        <small>+1.50€</small>
                    </div>
                    <div class="ingredient-item" data-ingredient="Chèvre" data-price="2.0" data-color="#fcf5e3">
                        <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI1MCIgaGVpZ2h0PSI1MCIgdmlld0JveD0iMCAwIDUwIDUwIj48Y2lyY2xlIGN4PSIyNSIgY3k9IjI1IiByPSIyMCIgZmlsbD0iI2ZjZjVlMyIgc3Ryb2tlPSIjZGRkIiBzdHJva2Utd2lkdGg=" alt="Chèvre" class="ingredient-icon">
                        <span>Chèvre</span>
                        <small>+2.00€</small>
                    </div>
                    <div class="ingredient-item" data-ingredient="Emmental" data-price="1.5" data-color="#f7e9a4">
                        <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI1MCIgaGVpZ2h0PSI1MCIgdmlld0JveD0iMCAwIDUwIDUwIj48Y2lyY2xlIGN4PSIyNSIgcyIgY3k9IjI1IiByPSIyMCIgZmlsbD0iI2Y3ZTlhNCIvPjwvc3ZnPg==" alt="Emmental" class="ingredient-icon">
                        <span>Emmental</span>
                        <small>+1.50€</small>
                    </div>
                    <div class="ingredient-item" data-ingredient="Bleu" data-price="2.0" data-color="#aec6cf">
                        <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI1MCIgaGVpZ2h0PSI1MCIgdmlld0JveD0iMCAwIDUwIDUwIj48Y2lyY2xlIGN4PSIyNSIgY3k9IjI1IiByPSIyMCIgZmlsbD0iI2FlYzdjZiIvPjwvc3ZnPg==" alt="Bleu" class="ingredient-icon">
                        <span>Bleu</span>
                        <small>+2.00€</small>
                    </div>
                </div>
            </div>
            
            <div class="ingredient-category">
                <h3>Viandes</h3>
                <div class="ingredients-grid">
                    <div class="ingredient-item" data-ingredient="Jambon" data-price="2.0" data-color="#ffcccb">
                        <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI1MCIgaGVpZ2h0PSI1MCIgdmlld0JveD0iMCAwIDUwIDUwIj48cmVjdCB4PSIxMCIgeT0iMTUiIHdpZHRoPSIzMCIgaGVpZ2h0PSIyMCIgZmlsbD0iI2ZmY2NjYiIgcng9IjUiLz48L3N2Zz4=" alt="Jambon" class="ingredient-icon">
                        <span>Jambon</span>
                        <small>+2.00€</small>
                    </div>
                    <div class="ingredient-item" data-ingredient="Pepperoni" data-price="2.5" data-color="#cc0000">
                        <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRo=" alt="Pepperoni" class="ingredient-icon">
                        <span>Pepperoni</span>
                        <small>+2.50€</small>
                    </div>
                    <div class="ingredient-item" data-ingredient="Poulet" data-price="2.0" data-color="#f5deb3">
                        <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI1MCIgaGVpZ2h0PSI1MCIgdmlld0JveD0iMCAwIDUwIDUwIj48Y2lyY2xlIGN4PSIyNSIgY3k9IjI1IiByPSIyMCIgZmlsbD0iI2Y1ZGViMyIvPjwvc3ZnPg==" alt="Poulet" class="ingredient-icon">
                        <span>Poulet</span>
                        <small>+2.00€</small>
                    </div>
                    <div class="ingredient-item" data-ingredient="Bœuf" data-price="2.5" data-color="#8b4513">
                        <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI1MCIgaGVpZ2h0PSI1MCIgdmlld0JveD0iMCAwIDUwIDUwIj48Y2lyY2xlIGN4PSIyNSIgY3k9IjI1IiByPSIyMCIgZmlsbD0iIzhiNDUxMyIvPjwvc3ZnPg==" alt="Bœuf" class="ingredient-icon">
                        <span>Bœuf</span>
                        <small>+2.50€</small>
                    </div>
                </div>
            </div>
            
            <div class="ingredient-category">
                <h3>Légumes</h3>
                <div class="ingredients-grid">
                    <div class="ingredient-item" data-ingredient="Champignons" data-price="1.5" data-color="#d2b48c">
                        <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI1MCIgaGVpZ2h0PSI1MCIgdmlld0JveD0iMCAwIDUwIDUwIj48ZWxsaXBzZSBjeD0iMjUiIGN5PSIyMCIgcng9IjE1IiByeT0iMTAiIGZpbGw9IiNkMmI0OGMiLz48cmVjdCB4PSIyMCIgeT0iMjAiIHdpZHRoPSIxMCIgaGVpZ2h0PSIxNSIgZmlsbD0iI2Y1ZjVkYyIvPjwvc3ZnPg==" alt="Champignons" class="ingredient-icon">
                        <span>Champignons</span>
                        <small>+1.50€</small>
                    </div>
                    <div class="ingredient-item" data-ingredient="Olives" data-price="1.5" data-color="#36454F">
                        <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy533My5vcmcvMjAwMC9zdmciIHdpZHRoPSI1MCIgaGVpZ2h0PSI1MCIgdmlld0JveD0iMCAwIDUwIDUwIj48Y2lyY2xlIGN4PSIyNSIgY3k9IjI1IiByPSIxMiIgZmlsbD0iIzM2NDU0RiIvPjwvc3ZnPg==" alt="Olives" class="ingredient-icon">
                        <span>Olives</span>
                        <small>+1.50€</small>
                    </div>
                    <div class="ingredient-item" data-ingredient="Poivrons" data-price="1.5" data-color="#ff6b6b">
                        <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI1MCIgaGVpZ2h0PSI1MCIgdmlld0JveD0iMCAwIDUwIDUwIj48Y2lyY2xlIGN4PSIyNSIgY3k9IjI1IiByPSIyMCIgZmlsbD0iI2ZmNmI2YiIvPjwvc3ZnPg==" alt="Poivrons" class="ingredient-icon">
                        <span>Poivrons</span>
                        <small>+1.50€</small>
                    </div>
                    <div class="ingredient-item" data-ingredient="Oignons" data-price="1.0" data-color="#dda0dd">
                        <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI1MCIgaGVpZ2h0PSI1MCIgdmlld0JveD0iMCAwIDUwIDUwIj48Y2lyY2xlIGN4PSIyNSIgY3k9IjI1IiByPSIyMCIgZmlsbD0iI2RkYTBkZCIvPjwvc3ZnPg==" alt="Oignons" class="ingredient-icon">
                        <span>Oignons</span>
                        <small>+1.00€</small>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="order-summary">
            <div class="table-info">Table: <strong id="table-number">#<?php echo $table_id; ?></strong></div>
            
            <div class="price-display">
                Prix total: <span id="total-price">8.50</span>€
            </div>
            
            <h3>Vos ingrédients:</h3>
            <div id="selected-ingredients">
                <!-- Les ingrédients sélectionnés apparaîtront ici -->
            </div>
            
            <form id="order-form" action="submit.php" method="POST">
                <input type="hidden" name="table_id" id="table-id-input" value="<?php echo $table_id; ?>">
                <input type="hidden" name="ingredients" id="ingredients-input">
                <input type="hidden" name="total_price" id="total-price-input">
                <button type="submit" id="order-btn" class="btn btn-success">Commander ma pizza</button>
            </form>
        </div>
    </div>

    <script>
        // === CONFIGURATION ===
        const basePrice = 8.50;
        let selectedIngredients = [];
        let totalPrice = basePrice;

        // === ÉLÉMENTS DOM ===
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

        // === POSITIONS DES INGRÉDIENTS ===
        const ingredientPositions = {
            'Mozzarella': [{x: 0, y: 0, size: 20}, {x: 0.3, y: 0.3, size: 20}, {x: -0.3, y: -0.3, size: 20}],
            'Chèvre': [{x: -0.2, y: 0.3, size: 15}, {x: 0.2, y: -0.3, size: 15}],
            'Emmental': [{x: 0.1, y: 0.3, size: 18}, {x: -0.1, y: -0.3, size: 18}],
            'Bleu': [{x: 0.2, y: 0.2, size: 12}, {x: -0.2, y: -0.2, size: 12}],
            'Jambon': [{x: 0.2, y: 0.1, size: 25}, {x: -0.2, y: -0.1, size: 25}],
            'Pepperoni': [{x: 0.3, y: 0.2, size: 18}, {x: -0.3, y: -0.2, size: 18}],
            'Poulet': [{x: 0, y: 0.2, size: 22}, {x: -0.1, y: -0.2, size: 22}],
            'Bœuf': [{x: 0.2, y: 0.25, size: 20}, {x: -0.2, y: -0.25, size: 20}],
            'Champignons': [{x: 0.15, y: 0.35, size: 16}, {x: -0.15, y: -0.35, size: 16}],
            'Olives': [{x: 0.25, y: 0.15, size: 10}, {x: -0.25, y: -0.15, size: 10}],
            'Poivrons': [{x: 0.2, y: 0.3, size: 14}, {x: -0.2, y: -0.3, size: 14}],
            'Oignons': [{x: 0.1, y: 0.25, size: 12}, {x: -0.1, y: -0.25, size: 12}]
        };

        // === FONCTIONS D'AFFICHAGE ===
        function initCanvas() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
        }

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

        function updatePizzaDisplay() {
            initCanvas();
            selectedIngredients.forEach(ingredient => {
                drawIngredient(ingredient);
            });
        }

        function updateIngredientsSummary() {
            selectedIngredientsContainer.innerHTML = '';
            selectedIngredients.forEach(ingredient => {
                const ingElement = document.createElement('div');
                ingElement.className = 'selected-ingredient';
                ingElement.innerHTML = `<span>${ingredient.name}</span>`;
                selectedIngredientsContainer.appendChild(ingElement);
            });
        }

        function updateTotalPrice() {
            totalPrice = basePrice;
            selectedIngredients.forEach(ingredient => {
                totalPrice += ingredient.price;
            });
            
            totalPriceElement.textContent = totalPrice.toFixed(2);
            totalPriceInput.value = totalPrice.toFixed(2);
        }

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

        // === GESTION DES ÉVÉNEMENTS ===
        ingredientItems.forEach(item => {
            item.addEventListener('click', function() {
                const ingredientName = this.getAttribute('data-ingredient');
                const ingredientPrice = parseFloat(this.getAttribute('data-price'));
                const ingredientColor = this.getAttribute('data-color');
                
                const existingIndex = selectedIngredients.findIndex(ing => ing.name === ingredientName);
                
                if (existingIndex === -1) {
                    selectedIngredients.push({ name: ingredientName, price: ingredientPrice, color: ingredientColor });
                    this.classList.add('selected');
                } else {
                    selectedIngredients.splice(existingIndex, 1);
                    this.classList.remove('selected');
                }
                
                updatePizzaDisplay();
                updateIngredientsSummary();
                updateTotalPrice();
            });
        });

        resetBtn.addEventListener('click', function() {
            selectedIngredients = [];
            ingredientItems.forEach(item => item.classList.remove('selected'));
            initCanvas();
            updateIngredientsSummary();
            updateTotalPrice();
            showAlert('Votre pizza a été réinitialisée', 'success');
        });

        orderForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            if (selectedIngredients.length === 0) {
                showAlert('Veuillez sélectionner au moins un ingrédient pour votre pizza.', 'error');
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
                    // Réinitialiser après succès
                    setTimeout(() => {
                        selectedIngredients = [];
                        ingredientItems.forEach(item => item.classList.remove('selected'));
                        initCanvas();
                        updateIngredientsSummary();
                        updateTotalPrice();
                    }, 2000);
                } else {
                    throw new Error(result.message || 'Erreur serveur');
                }
                
            } catch (error) {
                console.error('Erreur:', error);
                showAlert('Erreur lors de l\'envoi de la commande: ' + error.message, 'error');
            }
        });

        // === INITIALISATION ===
        initCanvas();
        updateTotalPrice();
    </script>
</body>
</html>