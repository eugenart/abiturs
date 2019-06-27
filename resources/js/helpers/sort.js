function sortByPos(a, b)
{
    return ((a.position < b.position) ? -1 : ((a.position > b.position) ? 1 : 0));
}

export default sortByPos
