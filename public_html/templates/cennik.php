{% extends 'layout.php' %}

{% block page_title %}Uprawnienia{% endblock %}
{% block content %} 
        <main class="cennik clearfix">
            <article class="cennik">
                <div class="title">Cennik</div>
                <table>
                    <tr>
                        <td rowspan="2"></td>
                        <td colspan="4">Ilość faktur</td>
                    </tr>
                    <tr>
                        <td>10</td>
                        <td>30</td>
                        <td>50</td>
                        <td>100</td>        
                    </tr>
                    <tr>
                        <td>ryczałt ewidencjonowany</td>
                        <td>80 zł</td>
                        <td>120 zł</td>
                        <td>150 zł</td>
                        <td>170 zł</td>        
                    </tr>
                    <tr>
                        <td>ryczałt ewidencjonowany + VAT</td>
                        <td>100 zł</td>
                        <td>150 zł</td>
                        <td>190 zł</td>
                        <td>250 zł</td>        
                    </tr>
                    <tr>
                        <td>podatkowa księga przychodów i rozchodów</td>
                        <td>80 zł</td>
                        <td>120 zł</td>
                        <td>150 zł</td>
                        <td>170 zł</td>      
                    </tr>
                    <tr>
                        <td>podatkowa księga przychodów i rozchodów + VAT</td>
                        <td>100 zł</td>
                        <td>150 zł</td>
                        <td>190 zł</td>
                        <td>250 zł</td>        
                    </tr>
                    <tr>
                        <td>księgi handlowe</td>
                        <td>400 zł</td>
                        <td>440 zł</td>
                        <td>500 zł</td>
                        <td>600 zł</td>        
                    </tr>
                    <tr>
                        <td>płace</td>
                        <td colspan="4">20 zł / pracownika</td>
                    </tr>
                    <tr>
                        <td>kadry i płace</td>
                        <td colspan="4">30 zł / pracownika</td>
                    </tr>    
                </table>
                <p>Podane ceny usług księgowych są cenami netto<br>
                    Wystawiamy faktury VAT za wykonane usługi</p>
            </article>
        </main>
{% endblock %}  