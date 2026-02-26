// public/js/utils.js
const Utils = {
    formatCurrency: function(amount) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(amount);
    },

    formatNumber: function(number) {
        return new Intl.NumberFormat('id-ID').format(number);
    },

    formatDate: function(dateString) {
        return new Date(dateString).toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'short',
            year: 'numeric'
        });
    }
};
