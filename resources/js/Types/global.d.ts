import { AxiosInstance } from 'axios';
import { route as ziggyRoute } from 'ziggy-js';
import { VNode, ComponentPublicInstance } from 'vue';

declare global {
    interface Window {
        axios: AxiosInstance;
    }

    var route: typeof ziggyRoute;

    namespace JSX {
        interface Element extends VNode {}
        interface ElementClass extends ComponentPublicInstance {}
        interface IntrinsicElements {
            [elem: string]: any;
        }
    }
}

declare module 'vue' {
    interface ComponentCustomProperties {
        route: typeof ziggyRoute;
    }
}