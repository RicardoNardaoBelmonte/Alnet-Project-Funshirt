<x-layouts::app.header>

<div class="bg-white dark:bg-zinc-900 min-h-screen">

    {{-- HERO --}}
    <div class="bg-zinc-100 dark:bg-zinc-950 border-b border-zinc-200 dark:border-zinc-800 py-20">
        <div class="max-w-3xl mx-auto px-6 text-center">
            <p class="text-amber-400 text-sm font-bold tracking-[0.3em] uppercase mb-5">We're Here to Help</p>
            <h1 class="text-5xl md:text-6xl font-black text-zinc-900 dark:text-white leading-tight mb-6">
                Support
            </h1>
            <p class="text-zinc-600 dark:text-zinc-400 text-lg leading-relaxed">
                Got a question, a problem, or just want to say hi? We've got you covered.
            </p>
        </div>
    </div>

    {{-- CONTENT --}}
    <div class="max-w-3xl mx-auto px-6 py-20 space-y-16">

        <section>
            <h2 class="text-2xl font-bold text-zinc-900 dark:text-white mb-4">How to Reach Us</h2>
            <p class="text-zinc-600 dark:text-zinc-400 leading-relaxed mb-4">
                Our support team is available Monday to Friday, 9:00 – 18:00 (WET / GMT+0). We aim to reply to all
                messages within 24 hours on business days.
            </p>
            <div class="bg-zinc-50 dark:bg-zinc-800 rounded-2xl p-6 border border-zinc-200 dark:border-zinc-700 flex flex-col gap-3">
                <div class="flex items-center gap-3">
                    <span class="text-amber-500 dark:text-amber-400 font-semibold text-sm w-24">Email</span>
                    <a href="mailto:support@funshirt.pt" class="text-zinc-700 dark:text-zinc-300 hover:text-zinc-900 dark:hover:text-white transition-colors">
                        support@funshirt.pt
                    </a>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-amber-500 dark:text-amber-400 font-semibold text-sm w-24">Hours</span>
                    <span class="text-zinc-700 dark:text-zinc-300">Mon – Fri, 09:00 – 18:00 (WET)</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-amber-500 dark:text-amber-400 font-semibold text-sm w-24">Response</span>
                    <span class="text-zinc-700 dark:text-zinc-300">Within 24 hours</span>
                </div>
            </div>
        </section>

        <section>
            <h2 class="text-2xl font-bold text-zinc-900 dark:text-white mb-6">Frequently Asked Questions</h2>
            <div class="space-y-6">

                <div>
                    <h3 class="text-zinc-900 dark:text-white font-semibold mb-2">How long does shipping take?</h3>
                    <p class="text-zinc-600 dark:text-zinc-400 leading-relaxed">
                        Standard orders are produced and shipped within 3–5 business days. Delivery within Portugal
                        takes an additional 1–2 days; international orders typically take 5–10 business days depending
                        on destination.
                    </p>
                </div>

                <div>
                    <h3 class="text-zinc-900 dark:text-white font-semibold mb-2">Can I return or exchange an item?</h3>
                    <p class="text-zinc-600 dark:text-zinc-400 leading-relaxed">
                        Since most of our products are made to order, we only accept returns for items that arrive
                        damaged or with a production defect. If this happens, contact us at
                        <a href="mailto:support@funshirt.pt" class="text-amber-500 dark:text-amber-400 hover:underline">support@funshirt.pt</a>
                        with a photo of the item within 7 days of delivery.
                    </p>
                </div>

                <div>
                    <h3 class="text-zinc-900 dark:text-white font-semibold mb-2">How do I track my order?</h3>
                    <p class="text-zinc-600 dark:text-zinc-400 leading-relaxed">
                        Once your order is dispatched you'll receive a confirmation email with a tracking link.
                        You can also check your order history in your account settings.
                    </p>
                </div>

                <div>
                    <h3 class="text-zinc-900 dark:text-white font-semibold mb-2">Can I customise an existing design?</h3>
                    <p class="text-zinc-600 dark:text-zinc-400 leading-relaxed">
                        Yes! Our Personalized service (coming soon) will let you upload your own graphic or tweak
                        any existing design. In the meantime, send us an email describing what you have in mind
                        and our team will help you out manually.
                    </p>
                </div>

                <div>
                    <h3 class="text-zinc-900 dark:text-white font-semibold mb-2">Which sizes do you carry?</h3>
                    <p class="text-zinc-600 dark:text-zinc-400 leading-relaxed">
                        We stock XS through 3XL for all catalogue designs. If you need a size outside that range
                        or a custom cut, reach out to us and we'll do our best to accommodate.
                    </p>
                </div>

            </div>
        </section>

        <section class="bg-zinc-50 dark:bg-zinc-800 rounded-2xl p-8 border border-zinc-200 dark:border-zinc-700 text-center">
            <h2 class="text-xl font-bold text-zinc-900 dark:text-white mb-3">Still have questions?</h2>
            <p class="text-zinc-600 dark:text-zinc-400 mb-6">Drop us a line and we'll get back to you as soon as possible.</p>
            <a
                href="mailto:support@funshirt.pt"
                class="inline-block bg-amber-400 hover:bg-amber-300 text-zinc-900 font-bold py-3 px-10 rounded-full transition-colors"
            >
                Email Support
            </a>
        </section>

    </div>

</div>

</x-layouts::app.header>
