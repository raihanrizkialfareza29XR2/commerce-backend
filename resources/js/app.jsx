import "./bootstrap";
import "../css/app.css";
import "../../public/css/bootstrap.min.css";
import "../../public/css/animate.css";
import "../../public/css/line-awesome.min.css";
import "../../public/css/themify-icons.css";
import "../../public/css/magnific-popup.css";
import "../../public/css/owl.carousel.css";
import "../../public/css/lightslider.min.css";
import "../../public/css/spacing.css";
import "../../public/css/theme.min.css";

import React from "react";
import { render } from "react-dom";
import { createInertiaApp } from "@inertiajs/inertia-react";
import { InertiaProgress } from "@inertiajs/progress";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";

const appName =
    window.document.getElementsByTagName("title")[0]?.innerText || "Laravel";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.jsx`,
            import.meta.glob("./Pages/**/*.jsx")
        ),
    setup({ el, App, props }) {
        return render(<App {...props} />, el);
    },
});

InertiaProgress.init({ color: "#4B5563" });
