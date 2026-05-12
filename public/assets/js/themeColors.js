// Select buttons
const primaryDefaultColor1Btn = document.querySelector('#switcher-primary1');
const primaryDefaultColor2Btn = document.querySelector('#switcher-primary2');
const primaryDefaultColor3Btn = document.querySelector('#switcher-primary3');
const primaryDefaultColor4Btn = document.querySelector('#switcher-primary4');
const primaryDefaultColor5Btn = document.querySelector('#switcher-primary5');

// Define colors
const colors = {
    color1: '82, 72, 223',
    color2: '0, 116, 186',
    color3: '10, 126, 164',
    color4: '250, 137, 107',
    color5: '1, 192, 200'
};

// Function to update color and save the selected button
function updateColor(color, buttonId) {
    // Save the selected color to localStorage
    localStorage.setItem("vistaprimaryColor", color);
    // Save the selected button ID to localStorage
    localStorage.setItem("selectedButton", buttonId);

    // Apply the color to the --primary-rgb CSS variable
    document.documentElement.style.setProperty('--primary-rgb', color);
    document.body.style.setProperty('--primary-rgb', color);
}

// Add event listeners
primaryDefaultColor1Btn.addEventListener('click', () => updateColor(colors.color1, 'switcher-primary1'));
primaryDefaultColor2Btn.addEventListener('click', () => updateColor(colors.color2, 'switcher-primary2'));
primaryDefaultColor3Btn.addEventListener('click', () => updateColor(colors.color3, 'switcher-primary3'));
primaryDefaultColor4Btn.addEventListener('click', () => updateColor(colors.color4, 'switcher-primary4'));
primaryDefaultColor5Btn.addEventListener('click', () => updateColor(colors.color5, 'switcher-primary5'));

// Initialize with the color and button stored in localStorage, if any
const storedColor = localStorage.getItem("vistaprimaryColor");
const selectedButton = localStorage.getItem("selectedButton");

if (storedColor) {
    document.documentElement.style.setProperty('--primary-rgb', storedColor);
    document.body.style.setProperty('--primary-rgb', storedColor);

    // Mark the previously selected button as checked
    if (selectedButton) {
        document.querySelector(`#${selectedButton}`).checked = true;
    }
}
