function calculateCaffeine() {
    let drink = document.getElementById("drink_name").value;
    let quantity = document.getElementById("quantity_ml").value;
    let caffeineField = document.getElementById("caffeine_mg");

    let caffeinePer100ml = 0;

    if (drink === "Coffee") {
        caffeinePer100ml = 40;
    } else if (drink === "Tea") {
        caffeinePer100ml = 20;
    } else if (drink === "Energy Drink") {
        caffeinePer100ml = 32;
    } else if (drink === "Soft Drink") {
        caffeinePer100ml = 10;
    }

    let caffeine = (quantity * caffeinePer100ml) / 100;

    if (!isNaN(caffeine)) {
        caffeineField.value = Math.round(caffeine);
    } else {
        caffeineField.value = "";
    }
}