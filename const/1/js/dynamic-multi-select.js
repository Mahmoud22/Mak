document.addEventListener("DOMContentLoaded", () => {
    const clientSelect = document.getElementById("clients");
    const projectSelect = document.getElementById("projects");

    // Fetch and populate clients
    fetch("http://localhost/const/1/form.php?action=getClients")
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
                return;
            }
            data.forEach(client => {
                const option = document.createElement("option");
                option.value = client.id;
                option.textContent = client.name;
                clientSelect.appendChild(option);
            });
        });

    // Fetch projects when clients are selected
    clientSelect.addEventListener("change", () => {
        // Clear previous projects
        projectSelect.innerHTML = "";

        // Get selected client IDs
        const selectedClients = Array.from(clientSelect.selectedOptions).map(opt => opt.value);

        // Fetch projects for each selected client
        const promises = selectedClients.map(clientId => 
            fetch(`http://localhost/const/1/form.php?action=getProjects&client_id=1
`).then(res => res.json())
        );

        // Merge and populate projects
        Promise.all(promises).then(results => {
            const projects = new Set();
            results.flat().forEach(project => {
                if (!projects.has(project.id)) {
                    projects.add(project.id);
                    const option = document.createElement("option");
                    option.value = project.id;
                    option.textContent = project.name;
                    projectSelect.appendChild(option);
                }
            });
        });
    });
});
// JavaScript Document