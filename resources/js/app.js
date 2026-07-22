import Alpine from 'alpinejs';

window.Alpine = Alpine;

document.addEventListener('alpine:init', () => {
    Alpine.store('rentalCart', {
        items: [],
        isOpen: false,

        init() {
            const saved = localStorage.getItem('pg_rental_cart');
            if (saved) {
                try {
                    this.items = JSON.parse(saved);
                    // Migrate old items
                    this.items.forEach(item => {
                        item.priceNum = this.parsePrice(item.price);
                        if (item.days && !item.quantity) {
                            item.quantity = item.days;
                        }
                        if (item.quantity && !item.days) {
                            item.days = item.quantity;
                        }
                    });
                    this.save();
                } catch (e) {
                    this.items = [];
                }
            }
        },

        save() {
            localStorage.setItem('pg_rental_cart', JSON.stringify(this.items));
        },

        parsePrice(priceStr) {
            if (!priceStr) return 0;
            const s = priceStr.toString().toLowerCase().trim();
            const isK = s.includes('k');
            const num = parseFloat(s.replace(/[^0-9]/g, ''));
            if (isNaN(num)) return 0;
            return isK ? num * 1000 : num;
        },

        formatPrice(num) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(num);
        },

        add(product, quantity = 1) {
            const existingIndex = this.items.findIndex(item => item.slug === product.slug && item.variant_id === product.variant_id);
            if (existingIndex > -1) {
                if (!product.stock || this.items[existingIndex].quantity + quantity <= product.stock) {
                    this.items[existingIndex].quantity += quantity;
                    this.items[existingIndex].days = this.items[existingIndex].quantity;
                }
            } else {
                const priceNum = this.parsePrice(product.price);
                this.items.push({
                    slug: product.slug,
                    title: product.title,
                    price: product.price,
                    priceNum: priceNum,
                    image: product.image,
                    category: product.category,
                    color: product.color || null,
                    size: product.size || null,
                    variant_id: product.variant_id || null,
                    variant_name: product.variant_name || null,
                    stock: product.stock || 0,
                    quantity: quantity,
                    days: quantity
                });
            }
            this.save();
            this.isOpen = true;
        },

        updateQuantity(slug, variant_id, quantity) {
            const index = this.items.findIndex(item => item.slug === slug && item.variant_id === variant_id);
            if (index > -1) {
                const newQty = parseInt(quantity, 10);
                if (newQty > 0) {
                    this.items[index].quantity = newQty;
                } else {
                    this.remove(slug, variant_id);
                }
                this.save();
            }
        },

        incrementQuantity(slug, variant_id) {
            const item = this.items.find(item => item.slug === slug && item.variant_id === variant_id);
            if (item) {
                if (!item.stock || item.quantity < item.stock) {
                    item.quantity++;
                    this.save();
                }
            }
        },

        decrementQuantity(slug, variant_id) {
            const item = this.items.find(item => item.slug === slug && item.variant_id === variant_id);
            if (item) {
                if (item.quantity > 1) {
                    item.quantity--;
                    this.save();
                } else {
                    this.remove(slug, variant_id);
                }
            }
        },

        remove(slug, variant_id) {
            this.items = this.items.filter(item => !(item.slug === slug && item.variant_id === variant_id));
            this.save();
        },

        clear() {
            this.items = [];
            this.save();
        },

        get count() {
            return this.items.reduce((total, item) => total + (item.quantity || item.days || 1), 0);
        },

        get itemCount() {
            return this.items.length;
        },

        get totalDays() {
            return this.items.reduce((total, item) => total + (item.quantity || item.days || 1), 0);
        },

        get totalPrice() {
            return this.items.reduce((total, item) => total + (item.priceNum * (item.quantity || item.days || 1)), 0);
        }
    });
});

Alpine.start();

