{% macro declension(number, forms) %}
{% set cases = [2, 0, 1, 1, 1, 2] %}
{# {{ number }} {{ forms[ ( number%100>4 and number%100<20)? 2 : cases[min(number%10, 5)] ] }} #}
{{ forms[ ( number%100>4 and number%100<20)? 2 : cases[(number%10<5)?number%10:5] ] }}
{% endmacro %}