import {toValue} from "vue";

export function usePrettyDate(date: Date) {
    return toValue(date).toLocaleDateString() + ' at ' + toValue(date).toLocaleTimeString();
}
