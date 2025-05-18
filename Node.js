const express = require('express');
const { OpenAI } = require('openai');
const bodyParser = require('body-parser');

const app = express();
const port = 3000;

// Use OpenAI's API key
const openai = new OpenAI({
  apiKey: 'YOUR_OPENAI_API_KEY',
});

app.use(bodyParser.json());

app.post('/chatbot', async (req, res) => {
  const userQuery = req.body.query;

  try {
    // Get a response from OpenAI's GPT-3 (or GPT-4)
    const completion = await openai.completions.create({
      model: 'text-davinci-003', // Or gpt-4
      prompt: userQuery,
      max_tokens: 150,
      temperature: 0.7,
    });

    // Return the response back to the frontend
    res.json({ response: completion.choices[0].text.trim() });
  } catch (error) {
    console.error('Error with OpenAI API:', error);
    res.status(500).json({ response: "Sorry, I couldn't process your request." });
  }
});

app.listen(port, () => {
  console.log(`Server running on http://localhost:${port}`);
});
