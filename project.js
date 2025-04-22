import fs from "fs";
import { GoogleGenAI } from "@google/genai";

const API_KEY = "AIzaSyBxVKKokgIAHjh_BuaQ3hVUj8gklLtEn08"

const ai = new GoogleGenAI({ apiKey: API_KEY });
const journalFile = "journal_history.json";

let history = [];
if (fs.existsSync(journalFile)) {
  history = JSON.parse(fs.readFileSync(journalFile));
}

const journalEntries = [
  {
    entry: "I failed one test, so I'll probably never be successful in school. I'm just not good enough.",
    mood: 3,
  },
  {
    entry: "My friend didn't reply to my text today. They must be mad at me or don't want to talk to me anymore.",
    mood: 4,
  },
  {
    entry: "I always mess things up. Nothing I do is ever good enough.",
    mood: 2,
  },
  {
    entry: "I got a low score on my assignment. I'm just stupid.",
    mood: 3,
  },
  {
    entry: "I didn't get picked for the team. I guess no one likes me.",
    mood: 5,
  },
];

// Analyze entry
async function analyzeEntry(entry, mood) {
  const response = await ai.models.generateContent({
    model: "gemini-2.0-flash",
    contents: `
You are a CBT-trained AI assistant. For the following journal entry:

1. Identify negative thinking patterns (e.g., overgeneralization, catastrophizing, labeling, personalization).
2. Explain why this thought is unhelpful.
3. Reframe it using CBT techniques with a kind and supportive tone.

Journal Entry:
"""${entry}"""
    `,
  });

  const analysis = response.text.trim();
  const record = {
    date: new Date().toISOString(),
    entry,
    mood,
    aiResponse: analysis,
  };

  history.push(record);
  fs.writeFileSync(journalFile, JSON.stringify(history, null, 2));

  console.log(`✍️ Entry:\n"${entry}"\n`);
  console.log("🌡️ Mood:", mood);
  console.log("🔍 AI Response:");
  console.log(analysis);
  console.log("\n---------------------------------\n");
}

// Summary
function showSummary() {
  const last7 = history.slice(-7);
  if (last7.length === 0) return;

  console.log("📊 Mood & Thought Summary (Last 7 Entries):");
  const avgMood =
    last7.reduce((acc, item) => acc + item.mood, 0) / last7.length;
  console.log(`→ Average Mood: ${avgMood.toFixed(1)} / 10`);

  const commonPatterns = {};
  for (const h of last7) {
    if (!h.aiResponse) continue;
    const matches = h.aiResponse.match(
      /(overgeneralization|catastrophizing|labeling|personalization|all-or-nothing|mental filtering)/gi
    );
    if (matches) {
      matches.forEach((m) => {
        const key = m.toLowerCase();
        commonPatterns[key] = (commonPatterns[key] || 0) + 1;
      });
    }
  }

  if (Object.keys(commonPatterns).length > 0) {
    console.log("→ Most Frequent Cognitive Distortions:");
    for (const [key, count] of Object.entries(commonPatterns)) {
      console.log(`   - ${key}: ${count}x`);
    }
  }

  console.log("\n✅ All entries analyzed and saved.\n");
}

// Main
async function main() {
  console.log("🧠 MindMate – AI Thought Coach");
  console.log("===============================\n");

  for (let i = 0; i < journalEntries.length; i++) {
    const { entry, mood } = journalEntries[i];
    await analyzeEntry(entry, mood);
  }

  showSummary();
}

main();
