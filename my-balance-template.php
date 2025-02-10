<?php
/*
Template Name: My Balance Template
*/

get_header();
?>

<div class="site-content">
    <h1><?php the_title(); ?></h1>
    <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
        <div class="form-tables">
            <table class="form-table th-activa">
                <thead>
                    <tr>
                        <th colspan="3"><h2>Aktiva</h2></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="form-group">
                        <td class="form-label"><label for="bankText">Bank</label></td>
                        <td>
                            <input type="text" id="bankText" name="bankText" value="Kontoguthaben" required>
                        </td>
                        <td>
                            <input type="number" id="bank" name="bank" required>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="form-label"><label for="depotText">Depot</label></td>
                        <td>
                            <input type="text" id="depotText" name="depotText" value="Swissquote" required>
                        </td>
                        <td>
                            <input type="number" id="depot" name="depot" required>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="form-label"><label for="aghText">Weiteres Vermögen</label></td>
                        <td>
                            <input type="text" id="aghText" name="aghText" value="Altersguthaben" required>
                        </td>
                        <td>
                            <input type="number" id="agh" name="agh" required>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="form-label"><label for="3aText">Säule 3a</label></td>
                        <td>
                            <input type="text" id="3aText" name="3aText" value="Säule 3a" required>
                        </td>
                        <td>
                            <input type="number" id="3a" name="3a" required>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="form-label"><label for="efhText">Immobilien</label></td>
                        <td>
                            <input type="text" id="efhText" name="efhText" value="EFH Speicherschwendi" required>
                        </td>
                        <td>
                            <input type="number" id="efh" name="efh" required>
                        </td>
                    </tr>
                </tbody>
            </table>

            <table class="form-table th-passiva">
                <thead>
                    <tr>
                        <th colspan="3"><h2>Passiva</h2></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="form-group">
                        <td class="form-label"><label for="loanText">Darlehen</label></td>
                        <td>
                            <input type="text" id="loanText" name="loanText" value="kurzfristig" required>
                        </td>
                        <td>
                            <input type="number" id="loan" name="loan" required>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="form-label"><label for="creditText">Kreditkarte</label></td>
                        <td>
                            <input type="text" id="creditText" name="creditText" value="Kreditkartenschuld" required>
                        </td>
                        <td>
                            <input type="number" id="credit" name="credit" required>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="form-label"><label for="mortgageText">Hypothek</label></td>
                        <td>
                            <input type="text" id="mortgageText" name="mortgageText" value="Hypothekenbetrag" required>
                        </td>
                        <td>
                            <input type="number" id="mortgage" name="mortgage" required>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="form-label"><label for="otherDebtText">Andere Schulden</label></td>
                        <td>
                            <input type="text" id="otherDebtText" name="otherDebtText" value="Andere Schulden" required>
                        </td>
                        <td>
                            <input type="number" id="otherDebt" name="otherDebt" required>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <input type="hidden" name="action" value="submit_form">
        <button type="submit">Submit</button>
    </form>
</div>

<?php
get_footer();
?>