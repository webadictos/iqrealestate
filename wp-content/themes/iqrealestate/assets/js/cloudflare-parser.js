export async function cloudflareParser(url) {
  try {
    const response = await fetch(url);
    if (!response.ok) {
      throw new Error('Failed to fetch CF trace');
    }
    const data = await response.text();

    let trace = {};
    let lines = data.split('\n');
    let keyValue;
    let countryCode = '';
    lines.forEach(function (line) {
      keyValue = line.split('=');
      trace[keyValue[0]] = decodeURIComponent(keyValue[1] || '');

      if (keyValue[0] === 'loc' && trace['loc'] !== 'XX') {
        localStorage.setItem('countryCode', trace['loc']);
        countryCode = trace['loc'];
      }
    });

    return countryCode;
  } catch (error) {
    throw new Error('Failed to fetch CF trace');
  }
}
