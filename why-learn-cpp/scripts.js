// Dark Mode Toggle
document.getElementById('toggle-mode').addEventListener('change', function () {
  const isDarkMode = this.checked;
  document.body.setAttribute('data-theme', isDarkMode ? 'dark' : 'light');
  document.querySelector('.mode-toggle').innerHTML = isDarkMode ? '<i class="fas fa-sun"></i>' : '<i class="fas fa-moon"></i>';
});

// RapidAPI Configuration
const JUDGE0_API_URL = 'https://judge0-ce.p.rapidapi.com/submissions/?base64_encoded=true&wait=true';
const RAPIDAPI_KEY = '47dfbed7f0mshbf3b7e745a734bbp109babjsnf408cf6ce7b5'; // Replace with your RapidAPI key

// Function to run code using the Judge0 API via RapidAPI
async function runCode() {
  const sourceCode = document.getElementById("cpp-code").value; // Get source code from textarea
  const languageId = 54; // C++ language ID for Judge0

  const submissionData = {
    source_code: btoa(sourceCode),  // Encode the source code in Base64
    language_id: languageId,
    stdin: btoa(""), // Optional input (if needed)
  };

  try {
    const response = await fetch(JUDGE0_API_URL, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-RapidAPI-Host": "judge0-ce.p.rapidapi.com",
        "X-RapidAPI-Key": "47dfbed7f0mshbf3b7e745a734bbp109babjsnf408cf6ce7b5", // Add the RapidAPI key
      },
      body: JSON.stringify(submissionData),
    });

    if (!response.ok) throw new Error("Error while submitting the code.");

    const result = await response.json();
    displayOutput(atob(result.stdout || ""), atob(result.stderr || ""), atob(result.compile_output || ""));
  } catch (error) {
    console.error("Execution Error: ", error);
    displayOutput("", "", "Execution failed. Please check the code and try again.");
  }
}

// Function to display the output in the browser
function displayOutput(stdout, stderr, compileOutput) {
  const outputElement = document.getElementById("output");
  outputElement.innerHTML = `
    <pre style="color: green;">${stdout}</pre>     <!-- Standard output -->
    <pre style="color: red;">${stderr}</pre>       <!-- Error output -->
    <pre style="color: orange;">${compileOutput}</pre> <!-- Compilation errors -->
  `;
}

// Add an event listener for the "Run Code" button
document.getElementById("run-button").addEventListener("click", runCode);
