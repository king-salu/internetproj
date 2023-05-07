function refresh() {
    const dd_1 = document.getElementById('select_teamA');
    const dd_2 = document.getElementById('select_teamB');

    const teamA = dd_1.options[dd_1.selectedIndex].value;
    const teamB = dd_2.options[dd_2.selectedIndex].value;

    if (teamA != teamB) {
        //alert(teamA, teamB);
        window.location.href = '/trade/' + teamA + '/' + teamB;
    }
}