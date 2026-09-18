document.addEventListener("DOMContentLoaded", function() {

    const ganttEl = document.getElementById("gantt");
    if (!ganttEl) return;

    // Tasks aus data-Attribut lesen
    const tasks = JSON.parse(ganttEl.dataset.tasks || '[]');

    if (!tasks.length) {
        ganttEl.innerHTML = "<p><em>Keine Tasks vorhanden.</em></p>";
        return;
    }

    // Frappe Gantt initialisieren
    new Gantt("#gantt", tasks, {
        view_mode: "Day",
        date_format: "YYYY-MM-DD",
        language: "de",
        custom_popup_html: task => `
            <div class="gantt-popup">
                <strong>${task.name}</strong><br>
                Start: ${task.start}<br>
                Ende: ${task.end}<br>
                Fortschritt: ${task.progress}%
            </div>
        `
    });
});
