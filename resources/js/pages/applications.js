// Add interactivity
document.addEventListener("DOMContentLoaded", function () {
    // Add row hover effect
    const rows = document.querySelectorAll("tbody tr");
    rows.forEach((row) => {
        row.addEventListener("mouseenter", function () {
            this.style.transform = "translateX(4px)";
        });

        row.addEventListener("mouseleave", function () {
            this.style.transform = "translateX(0)";
        });
    });

    // Status change confirmation
    const statusSelects = document.querySelectorAll('select[name="status"]');
    statusSelects.forEach((select) => {
        const originalValue = select.value;

        select.addEventListener("change", function (e) {
            // if (this.value === 'pending' && originalValue !== 'pending') {
            //     if (!confirm('Are you sure you want to pending this application?')) {
            //         this.value = originalValue;
            //         return false;
            //     }
            // }
            // if (this.value === 'under_reviewed' && originalValue !== 'under_reviewed') {
            //     if (!confirm('Are you sure you want to under reviewed this application?')) {
            //         this.value = originalValue;
            //         return false;
            //     }
            // }
            // if (this.value === 'accepted' && originalValue !== 'accepted') {
            //     if (!confirm('Are you sure you want to accept this application?')) {
            //         this.value = originalValue;
            //         return false;
            //     }
            // }
            // if (this.value === 'rejected' && originalValue !== 'rejected') {
            //     if (!confirm('Are you sure you want to reject this application?')) {
            //         this.value = originalValue;
            //         return false;
            //     }
            // }
            // if (this.value === 'shortlisted' && originalValue !== 'shortlisted') {
            //     if (!confirm('Are you sure you want to short listed this application?')) {
            //         this.value = originalValue;
            //         return false;
            //     }
            // }
            //   if (this.value === 'interview' && originalValue !== 'interview') {
            //     if (!confirm('Are you sure you want to interview this application?')) {
            //         this.value = originalValue;
            //         return false;
            //     }
            // }
        });
    });

    // Tooltips
    const tooltipElements = document.querySelectorAll("[title]");
    tooltipElements.forEach((el) => {
        el.addEventListener("mouseenter", function (e) {
            const tooltip = document.createElement("div");
            tooltip.className =
                "fixed z-50 px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-lg";
            tooltip.textContent = this.title;
            document.body.appendChild(tooltip);

            const rect = this.getBoundingClientRect();
            tooltip.style.top = rect.top - 40 + "px";
            tooltip.style.left =
                rect.left + rect.width / 2 - tooltip.offsetWidth / 2 + "px";

            this._tooltip = tooltip;
        });

        el.addEventListener("mouseleave", function () {
            if (this._tooltip) {
                this._tooltip.remove();
            }
        });
    });
});
