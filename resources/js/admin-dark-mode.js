// Admin Dark Mode Select Dropdown Fixes
document.addEventListener('DOMContentLoaded', function() {
    // Function to fix select dropdown styling in dark mode
    function fixSelectDropdowns() {
        const isDarkMode = document.documentElement.classList.contains('dark');
        const selects = document.querySelectorAll('select');
        
        selects.forEach(select => {
            // Force dark mode styling for select elements
            if (isDarkMode) {
                select.style.backgroundColor = '#1e293b';
                select.style.color = '#f1f5f9';
                select.style.borderColor = '#475569';
            }
            
            // Fix option elements
            const options = select.querySelectorAll('option');
            options.forEach(option => {
                if (isDarkMode) {
                    option.style.backgroundColor = '#1e293b';
                    option.style.color = '#f1f5f9';
                }
            });
        });
    }
    
    // Initial fix
    fixSelectDropdowns();
    
    // Watch for dark mode changes
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                setTimeout(fixSelectDropdowns, 100);
            }
        });
    });
    
    // Observe the html element for class changes
    observer.observe(document.documentElement, {
        attributes: true,
        attributeFilter: ['class']
    });
    
    // Fix dropdowns when they are dynamically added
    const selectObserver = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'childList') {
                mutation.addedNodes.forEach(function(node) {
                    if (node.nodeType === 1) { // Element node
                        if (node.tagName === 'SELECT') {
                            setTimeout(fixSelectDropdowns, 100);
                        } else if (node.querySelectorAll) {
                            const newSelects = node.querySelectorAll('select');
                            if (newSelects.length > 0) {
                                setTimeout(fixSelectDropdowns, 100);
                            }
                        }
                    }
                });
            }
        });
    });
    
    // Observe the entire document for new select elements
    selectObserver.observe(document.body, {
        childList: true,
        subtree: true
    });
});

// Additional fix for Alpine.js components
document.addEventListener('alpine:init', function() {
    Alpine.data('selectDropdown', () => ({
        init() {
            this.$nextTick(() => {
                this.fixDropdownStyling();
            });
        },
        
        fixDropdownStyling() {
            const isDarkMode = document.documentElement.classList.contains('dark');
            const selects = this.$el.querySelectorAll('select');
            
            selects.forEach(select => {
                if (isDarkMode) {
                    select.style.backgroundColor = '#1e293b';
                    select.style.color = '#f1f5f9';
                    select.style.borderColor = '#475569';
                }
                
                const options = select.querySelectorAll('option');
                options.forEach(option => {
                    if (isDarkMode) {
                        option.style.backgroundColor = '#1e293b';
                        option.style.color = '#f1f5f9';
                    }
                });
            });
        }
    }));
});
