const urls = [
  'https://jsonplaceholder.typicode.com/todos/1', 
  'https://api.ipify.org?format=json', 
  'https://api.github.com/users/github', 
];

async function fetchData(url) {
  try {
    console.log(`Запит до ${url}...`);
    const response = await fetch(url);
    console.log(`Відповідь від ${url}:`, response);
    if (!response.ok) {
      throw new Error(`Помилка HTTP: ${response.status}`);
    }
    if (Math.random() < 0.2) {
      throw new Error('Симуляція помилки');
    }
    const data = await response.json();
    console.log(`Дані з ${url}:`, data);
    return data;
  } catch (error) {
    console.error(`Помилка при отриманні ${url}:`, error);
    throw error;
  }
}

async function fetchAllData(urls) {
  let results = await Promise.allSettled(urls.map(fetchData));

  const errors = results
    .map((result, index) => (result.status === 'rejected' ? { index, url: urls[index], error: result.reason } : null))
    .filter(Boolean);

  if (errors.length > 0) {
    console.log('Помилки при першому запиті:', errors);
    console.log('Спроба повторити через 1 секунду...');
    await new Promise((resolve) => setTimeout(resolve, 1000));

    const retryResults = await Promise.allSettled(errors.map(({ url }) => fetchData(url)));

    retryResults.forEach((result, index) => {
      if (result.status === 'fulfilled') {
        results[errors[index].index] = result;
      }
    });
  }

  console.log('Результати:', results);
}

fetchAllData(urls);
