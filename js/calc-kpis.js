// calculate-kpis.js
module.exports = function calculateKPIs(data) {
    // Extract and convert values to numbers
    const bank = parseFloat(data.bank) || 0;
    const depot = parseFloat(data.depot) || 0;
    const agh = parseFloat(data.agh) || 0;
    const s3a = parseFloat(data.s3a) || 0;
    const efh = parseFloat(data.efh) || 0;
    const loan = parseFloat(data.loan) || 0;
    const credit = parseFloat(data.credit) || 0;
    const mortgage = parseFloat(data.mortgage) || 0;
    const otherDebt = parseFloat(data.otherDebt) || 0;

    // Calculate Liquidität (Liquidity)
    const liquidity = bank + depot + agh + s3a + efh;

    // Calculate Schuldenquote (Debt Ratio)
    const totalDebt = loan + credit + mortgage + otherDebt;
    const debtRatio = liquidity === 0 ? 0 : totalDebt / liquidity;

    // Return the results
    return {
        Liquidität: liquidity,
        Schuldenquote: debtRatio,
        message: 'Deine Privatbilanz wurde erfolgreich analysiert!',
    };
};
