<?php

namespace App\Services;

class ChatService
{
    private array $knowledge = [

        // ═══════════════════════════════════════════════════════════
        // TOPIC 1: SELF-EXAMINATION
        // ═══════════════════════════════════════════════════════════
        'self_exam' => [
            'keywords' => [
                // English (broad coverage)
                'self exam', 'self-exam', 'self examination', 'self-examination',
                'check myself', 'examine myself', 'examine my breast', 'examine my breasts',
                'feel my breast', 'feel my breasts', 'breast check', 'monthly check',
                'detect at home', 'home exam', 'home examination', 'home test',
                'look for lumps', 'check for lumps', 'find lumps',
                'how to check', 'how to examine', 'how do i check',
                'how do i examine', 'how can i check', 'how can i examine',
                'do a check', 'perform a check', 'conduct an exam',
                'step by step exam', 'steps to check', 'checking breasts',
                'touching breast', 'feeling breast', 'palpation',
                'mirror check', 'shower check', 'lying down check',
                'bse', 'breast self',
                // French
                'auto-examen', 'auto examen', 'examiner mes seins', 'examiner seins',
                'comment vérifier', 'vérifier mes seins', 'palper', 'palper mes seins',
                'contrôler mes seins', 'toucher mes seins', 'examen à la maison',
                'comment examiner', 'étapes examen',
                // Kinyarwanda
                'kwisuzuma', 'gusuzuma amabere', 'gusuzuma ibere', 'nisuzume nte', 'kwisuzuma buri kwezi',
                'kwigenzura', 'gupima amabere', 'gukora isuzuma', 'kwisuzuma', "kanseri y'ibere", "kanseri y'amabere",
                'kwisuzuma mu ndorerwamo', 'guhindura ibara', 'kwisuzuma uryamye', 'nakisuzuma', 'nisuzuma', 'kwireba'
            ],
            'response' => [
                'en' => "How to do a breast self-exam:\n\n1. LOOK — Stand in front of a mirror with arms at your sides. Look for changes in size, shape, skin dimpling, or nipple changes. Raise your arms and look again.\n\n2. FEEL (standing) — Use the pads of your three middle fingers. Press in small circles covering the entire breast, from collarbone to below the breast, and from armpit to center of chest. Use light, medium, and firm pressure.\n\n3. FEEL (lying down) — Lie down with a pillow under your right shoulder. Use your left hand to examine your right breast using the same circular motion. Switch sides.\n\n4. CHECK NIPPLES — Gently squeeze each nipple to check for discharge.\n\nDo this once a month, ideally a few days after your period ends when breasts are least tender. If you notice anything unusual, see a health professional — do not wait.",
                'fr' => "Comment faire un auto-examen des seins :\n\n1. REGARDER — Placez-vous devant un miroir. Cherchez des changements de taille, forme, plis de la peau ou modifications du mamelon. Levez les bras et regardez à nouveau.\n\n2. PALPER (debout) — Utilisez les coussinets de vos trois doigts du milieu. Faites de petits cercles en couvrant tout le sein, de la clavicule jusqu'en dessous du sein, et de l'aisselle au centre.\n\n3. PALPER (allongée) — Allongez-vous avec un coussin sous l'épaule droite. Examinez le sein droit avec la main gauche. Changez de côté.\n\n4. VÉRIFIER LES MAMELONS — Pressez doucement chaque mamelon pour vérifier s'il y a un écoulement.\n\nFaites cet examen une fois par mois, quelques jours après la fin de vos règles. Si vous remarquez quelque chose d'inhabituel, consultez un professionnel de santé.",
                'rw' => "Gusuzuma amabere wenyine:\n\n1. KUREBA — Hagarara imbere y'indorerwamo, amaboko ku mpande. Reba niba hari impinduka mu bunini, ishusho, uruhu ruhindutse, cyangwa impinduka ku mutwaro. Zana amaboko hejuru urebe nanone.\n\n2. GUKORAKORA (uhagaze) — Koresha intoki eshatu zo hagati. Fata uduce duto dutumbereye ugenzura ibere ryose, kuva ku gikanu kugera munsi y'ibere, no kuva mu nkokora kugera hagati.\n\n3. GUKORAKORA (uryamye) — Ryama uteruye umusego munsi y'igitugu cy'iburyo. Koresha ikiganza cy'ibumoso gusuzuma ibere ry'iburyo. Hindura.\n\n4. GUSUZUMA IMITWARO — Fata buhoro buhoro buri mutwaro urebe niba hari ikintu gisohoka.\n\nBikore rimwe mu kwezi, nyuma y'iminsi mike imvura yawe irangiye. Niba ubonye ikintu kitasanzwe, gana umuganga — ntutegereze.",
            ],
        ],

        // ═══════════════════════════════════════════════════════════
        // TOPIC 2: SYMPTOMS & WARNING SIGNS
        // ═══════════════════════════════════════════════════════════
        'symptoms' => [
            'keywords' => [
                // English (very broad)
                'signs', 'symptoms', 'symptom', 'warning', 'warning sign',
                'early signs', 'early symptoms', 'first signs', 'first symptom',
                'what to look for', 'what to watch for', 'what to watch out for',
                'how do i know', 'how would i know', 'how to tell',
                'how can i tell', 'can i tell', 'tell if i have',
                'red flags', 'red flag', 'indicators', 'indicator',
                'breast cancer signs', 'signs of breast cancer', 'signs of cancer',
                'cancer symptoms', 'cancer signs',
                'notice', 'noticed', 'something wrong', 'worried about',
                'worried', 'concern', 'concerned', 'suspicious',
                'changes in my breast', 'breast changes', 'change in breast',
                'pain in breast', 'breast pain', 'breast hurts', 'breast ache',
                'sore breast', 'tender breast', 'painful breast',
                'lump', 'lumps', 'bump', 'bumps', 'knot', 'knots', 'mass',
                'hard spot', 'hard lump', 'hard area', 'thickening',
                'swelling', 'swollen', 'swollen breast', 'puffiness',
                'nipple discharge', 'discharge', 'leaking nipple', 'nipple leaking',
                'bleeding nipple', 'bloody discharge', 'fluid from nipple',
                'skin change', 'skin changes', 'skin dimpling', 'dimpling',
                'puckering', 'orange peel', 'peau d\'orange',
                'redness', 'red skin', 'red breast', 'discoloration',
                'flaky skin', 'scaly skin', 'peeling skin', 'crusty nipple',
                'inverted nipple', 'nipple retraction', 'nipple turned inward',
                'nipple pulling', 'nipple sinking',
                'armpit lump', 'underarm lump', 'lymph node', 'swollen armpit',
                'what does cancer feel like', 'feel like cancer',
                'breast itching', 'itchy breast', 'itchy nipple',
                'warm breast', 'hot breast', 'breast heat',
                'breast infection', 'breast abscess',
                'one breast bigger', 'uneven breasts', 'asymmetric',
                // French
                'symptômes', 'signes', 'signes d\'alerte', 'premiers signes',
                'comment savoir', 'bosse', 'boule', 'grosseur',
                'douleur', 'douleur au sein', 'mal au sein', 'sein douloureux',
                'écoulement', 'écoulement du mamelon', 'mamelon qui coule',
                'rougeur', 'peau d\'orange', 'changement de peau',
                'gonflement', 'sein gonflé', 'mamelon rétracté',
                'ganglion', 'aisselle', 'masse',
                'inquiète', 'préoccupée',
                // Kinyarwanda
                'ibimenyetso', 'kumenya', 'ububabare', 'ububabare bw\'amabere',
                'igikuba', 'ubukomere', 'kubyimba', 'impinduka',
                'amaraso', 'ibisohoka', 'umumero', 'ibibyimba',
                'inkokora', 'kurwara', 'kuribwa', 'gukomera', 'gukura', 'guhindura ibara',
            ],
            'response' => [
                'en' => "Warning signs of breast cancer:\n\n• A new lump or hard knot in the breast or underarm area\n• Thickening or swelling in part of the breast\n• Change in breast size or shape\n• Skin dimpling or puckering (looks like orange peel)\n• Nipple turning inward (retraction)\n• Nipple discharge other than breast milk, especially if bloody\n• Redness, dryness, flaking, or scaling skin on breast or nipple\n• Persistent pain in one specific area of the breast\n• Itching, warmth, or redness that doesn't go away\n• Swollen lymph nodes under the arm or near the collarbone\n\nImportant: Many of these changes can also be caused by conditions that are NOT cancer (like cysts, infections, or hormonal changes). But any new or unusual change should be checked by a health professional to be safe.",
                'fr' => "Signes d'alerte du cancer du sein :\n\n• Une nouvelle bosse ou nœud dur dans le sein ou sous le bras\n• Épaississement ou gonflement d'une partie du sein\n• Changement de taille ou de forme du sein\n• Fossettes ou plissement de la peau (aspect peau d'orange)\n• Rétraction du mamelon (mamelon qui rentre)\n• Écoulement du mamelon, surtout s'il est sanglant\n• Rougeur, sécheresse ou desquamation de la peau du sein ou du mamelon\n• Douleur persistante dans une zone du sein\n• Démangeaisons, chaleur ou rougeur qui ne disparaît pas\n• Ganglions lymphatiques enflés sous le bras\n\nImportant : Beaucoup de ces changements peuvent être causés par des conditions qui ne sont PAS un cancer. Mais tout changement doit être vérifié par un professionnel de santé.",
                'rw' => "Ibimenyetso by'umugera w'amabere:\n\n• Igikuba gishya cyangwa ubukomere mu ibere cyangwa munsi y'inkokora\n• Kubyimba cyangwa gukura mu gice cy'ibere\n• Impinduka mu bunini cyangwa ishusho y'ibere\n• Uruhu rufatanya cyangwa rukunjagara (rumeze nk'uruhu rw'icunga)\n• Umumero winjiye imbere\n• Ibisohoka mu mutwaro, cyane cyane amaraso\n• Ubutuku, gukomera, cyangwa guhindura ibara ry'uruhu ku ibere cyangwa umumero\n• Ububabare buhoraho mu gice kimwe cy'ibere\n• Uburibwe, ubushyuhe, cyangwa ubutuku bidashira\n• Kubyimba munsi y'inkokora\n\nIbyingenzi: Byinshi muri ibi bishobora guterwa n'izindi ndwara ATARI kanseri. Ariko impinduka iyo ari yo yose igomba gusuzumwa n'umuganga.",
            ],
        ],

        // ═══════════════════════════════════════════════════════════
        // TOPIC 3: RISK FACTORS
        // ═══════════════════════════════════════════════════════════
        'risk_factors' => [
            'keywords' => [
                // English (broad)
                'risk', 'risks', 'risk factor', 'risk factors',
                'causes', 'cause', 'what causes', 'caused by',
                'why', 'why do people get', 'why do women get',
                'chance', 'chances', 'odds', 'probability', 'likelihood',
                'likely', 'more likely', 'less likely',
                'who gets', 'who gets cancer', 'who is at risk',
                'am i at risk', 'could i get', 'will i get',
                'increase risk', 'higher risk', 'high risk',
                'lower risk', 'reduce risk', 'decrease risk',
                'prevent', 'prevention', 'preventable', 'protect',
                'avoid', 'how to avoid', 'how to prevent',
                'family history', 'runs in family', 'in my family',
                'mother had', 'sister had', 'grandmother had', 'aunt had',
                'genetic', 'genetics', 'gene', 'genes', 'hereditary', 'inherited',
                'brca', 'brca1', 'brca2', 'mutation',
                'age risk', 'age factor', 'too young', 'too old',
                'obesity', 'overweight', 'weight', 'fat', 'bmi',
                'alcohol', 'drinking', 'smoke', 'smoking',
                'hormones', 'hormone', 'estrogen', 'progesterone', 'hrt',
                'hormone replacement', 'birth control', 'contraceptive',
                'pill', 'oral contraceptive',
                'diet', 'food', 'nutrition', 'exercise', 'physical activity',
                'lifestyle', 'healthy living', 'healthy lifestyle',
                'radiation exposure', 'chest radiation',
                'dense breasts', 'breast density',
                'menstruation', 'period', 'early period', 'late menopause',
                'menopause', 'never had children', 'nulliparous', 'childless',
                'first pregnancy', 'late pregnancy',
                'protect myself', 'lower my risk', 'reduce my risk',
                // French
                'facteurs de risque', 'facteur de risque', 'risque', 'risques',
                'causes', 'prévenir', 'prévention', 'éviter',
                'antécédents familiaux', 'histoire familiale', 'hérédité',
                'génétique', 'obésité', 'alcool', 'hormones',
                'activité physique', 'mode de vie',
                'protéger', 'réduire le risque',
                // Kinyarwanda
                'ibyago', 'impamvu', 'kwirinda', 'uburyo bwo kwirinda',
                'amateka y\'umuryango', 'umuryango', 'gene',
                'imyitozo', 'ibiro', 'inzoga',
                'gukingira', 'kugabanya ibyago',
            ],
            'response' => [
                'en' => "Breast cancer risk factors:\n\nFactors you CANNOT change:\n• Being female (main risk factor)\n• Age — risk increases after 40, especially after 50\n• Family history — mother, sister, or daughter with breast cancer doubles risk\n• Genetic mutations — BRCA1/BRCA2 genes significantly increase risk\n• Early menstruation (before age 12)\n• Late menopause (after age 55)\n• Previous breast biopsy showing abnormal cells\n• Dense breast tissue\n• Previous radiation to the chest\n• Personal history of breast cancer\n\nFactors you CAN influence:\n• Physical activity — 30 min exercise most days lowers risk\n• Healthy weight — obesity after menopause increases risk\n• Alcohol — even small amounts increase risk; less is better\n• Breastfeeding — may lower risk, especially over 1 year total\n• First pregnancy before age 30 is associated with lower risk\n• Avoiding long-term hormone replacement therapy\n• Eating a balanced diet rich in fruits and vegetables\n• Not smoking\n\nHaving risk factors does NOT mean you will get cancer. Many women with risk factors never develop it, and some with no known risk factors do. But knowing your risks helps you stay vigilant with screening.",
                'fr' => "Facteurs de risque du cancer du sein :\n\nFacteurs non modifiables :\n• Être une femme\n• L'âge — risque augmente après 40 ans, surtout après 50 ans\n• Antécédents familiaux — mère, sœur ou fille ayant eu un cancer du sein\n• Mutations génétiques (BRCA1, BRCA2)\n• Premières règles précoces (avant 12 ans)\n• Ménopause tardive (après 55 ans)\n• Biopsie mammaire antérieure avec cellules anormales\n• Tissu mammaire dense\n\nFacteurs modifiables :\n• Activité physique régulière — 30 min par jour\n• Maintenir un poids santé\n• Limiter l'alcool\n• Allaitement maternel — effet protecteur\n• Première grossesse avant 30 ans\n• Éviter l'hormonothérapie de remplacement prolongée\n• Alimentation équilibrée\n• Ne pas fumer\n\nAvoir des facteurs de risque ne signifie pas que vous aurez un cancer. Mais connaître vos risques vous aide à rester vigilante avec le dépistage.",
                'rw' => "Ibyago by'umugera w'amabere:\n\nIbyago udashobora guhindura:\n• Kuba uri umugore\n• Imyaka — ibyago biriyongera nyuma y'imyaka 40\n• Amateka y'umuryango — nyina, mushiki, cyangwa umukobwa wagize kanseri y'amabere\n• Impinduka za gene (BRCA1, BRCA2)\n• Imvura itangira kare (mbere y'imyaka 12)\n• Imvura irangira kera (nyuma y'imyaka 55)\n• Gusuzumwa amabere mbere byagaragaje ingirabuzimafatizo zidafite isura\n\nIbyago ushobora guhindura:\n• Imyitozo ngororamubiri — iminota 30 buri munsi\n• Ibiro byo ku mubiri bikwiye\n• Kugabanya inzoga\n• Konsa — birinda kanseri\n• Kubyara bwa mbere mbere y'imyaka 30\n• Kurya neza — imbuto n'imboga nyinshi\n• Kutanywa itabi\n\nKugira ibyago ntibisobanura ko uzagira kanseri. Ariko kumenya ibyago byawe bigufasha kwisuzumisha kenshi.",
            ],
        ],

        // ═══════════════════════════════════════════════════════════
        // TOPIC 4: SCREENING GUIDELINES
        // ═══════════════════════════════════════════════════════════
        'screening' => [
            'keywords' => [
                // English
                'screening', 'screen', 'mammogram', 'mammography', 'mamogram',
                'when to screen', 'how often', 'how often should',
                'ultrasound', 'breast ultrasound', 'sonogram',
                'check up', 'checkup', 'check-up', 'annual check',
                'test', 'tests', 'testing', 'tested', 'diagnostic',
                'diagnose', 'diagnosis', 'diagnosed', 'detection',
                'should i be tested', 'should i get tested', 'need a test',
                'how is it detected', 'how is it found', 'how is it diagnosed',
                'clinical exam', 'clinical breast exam', 'cbe',
                'doctor visit', 'doctor appointment', 'see a doctor',
                'when should i go', 'when to see doctor', 'when to visit',
                'how often check', 'regular check', 'routine check',
                'x-ray', 'xray', 'breast scan', 'scan',
                'mri', 'breast mri', 'biopsy',
                'early detection', 'find it early', 'catch it early',
                'annual screening', 'yearly screening', 'regular screening',
                // French
                'dépistage', 'mammographie', 'échographie',
                'quand consulter', 'quand aller', 'test',
                'examen clinique', 'examen des seins',
                'détection précoce', 'diagnostic',
                'rendez-vous', 'consulter', 'médecin',
                'radiographie', 'biopsie', 'irm',
                // Kinyarwanda
                'gusuzumwa', 'isuzuma', 'kwa muganga',
                'gupimwa', 'igenzura', 'kugenzurwa',
                'mammografi', 'echografi',
                'kumenya kare', 'gusura muganga',
            ],
            'response' => [
                'en' => "Breast cancer screening recommendations:\n\n• Ages 20-39: Monthly self-exam. Clinical breast exam by a professional every 1–3 years.\n• Ages 40–49: Monthly self-exam. Annual clinical exam. Discuss starting mammography with your doctor.\n• Ages 50+: Monthly self-exam. Annual mammogram where available. Annual clinical exam.\n\nTypes of screening:\n• Self-exam — You check your own breasts monthly at home. Free and always available.\n• Clinical breast exam (CBE) — A trained health worker examines your breasts by hand.\n• Ultrasound — Uses sound waves to create images. Good for dense breasts. More available than mammography.\n• Mammogram — X-ray of the breast. Gold standard for detection but requires specialized equipment.\n• MRI — Used for very high-risk women. Most detailed but expensive.\n• Biopsy — If something suspicious is found, a small tissue sample is taken and examined.\n\nIn areas where mammography is not available, clinical breast exams and ultrasound are valuable alternatives. The most important thing is to be screened regularly by whatever method is accessible to you.",
                'fr' => "Recommandations de dépistage :\n\n• 20-39 ans : Auto-examen mensuel. Examen clinique tous les 1 à 3 ans.\n• 40–49 ans : Auto-examen mensuel. Examen clinique annuel. Discutez de la mammographie.\n• 50+ ans : Auto-examen mensuel. Mammographie annuelle si disponible.\n\nTypes de dépistage :\n• Auto-examen — Vérifiez vos seins chaque mois à la maison\n• Examen clinique — Un professionnel examine vos seins\n• Échographie — Bonne alternative quand la mammographie n'est pas disponible\n• Mammographie — Référence, mais nécessite un équipement spécialisé\n• IRM — Pour les femmes à très haut risque\n• Biopsie — Si quelque chose de suspect est trouvé, un échantillon est prélevé\n\nLe plus important est de se faire dépister régulièrement par la méthode accessible.",
                'rw' => "Amabwiriza yo gusuzumwa kanseri y'amabere:\n\n• Imyaka 20-39: Kwisuzuma buri kwezi. Muganga buri myaka 1–3.\n• Imyaka 40–49: Kwisuzuma buri kwezi. Muganga buri mwaka.\n• Imyaka 50+: Kwisuzuma buri kwezi. Mammografi buri mwaka niba iboneka.\n\nUburyo bwo gusuzumwa:\n• Kwisuzuma — Ugasuzuma amabere yawe buri kwezi mu rugo\n• Isuzuma rya muganga — Umuganga asuzuma amabere yawe n'intoki\n• Echografi — Ikoresha imivumba y'amajwi. Ni uburyo bwiza iyo mammografi idahari\n• Mammografi — Ifoto y'amabere. Ni uburyo bwiza cyane ariko busaba ibikoresho bidasanzwe\n• Biopsiya — Niba hari ikintu gishidikanywaho, bafata agace gato bakagenzura\n\nIkintu cy'ingenzi ni ugusuzumwa buri gihe ukoresheje uburyo uboneka.",
            ],
        ],

        // ═══════════════════════════════════════════════════════════
        // TOPIC 5: TREATMENT
        // ═══════════════════════════════════════════════════════════
        'treatment' => [
            'keywords' => [
                // English (very broad)
                'treatment', 'treatments', 'treat', 'treated', 'treatable',
                'cure', 'cured', 'curable', 'cureable', 'can it be cured',
                'survive', 'survival', 'survival rate', 'survivable',
                'what happens next', 'what happens if', 'what if diagnosed',
                'after diagnosis', 'diagnosed with',
                'surgery', 'operation', 'surgical', 'lumpectomy', 'mastectomy',
                'remove breast', 'breast removal', 'breast reconstruction',
                'chemo', 'chemotherapy', 'chemo therapy',
                'radiation', 'radiation therapy', 'radiotherapy',
                'hormone therapy', 'hormonal therapy', 'tamoxifen',
                'targeted therapy', 'immunotherapy', 'biological therapy',
                'medicine', 'medication', 'drugs', 'drug', 'pills',
                'hospital', 'hospitalization', 'admitted',
                'prognosis', 'outcome', 'outlook',
                'recovery', 'recover', 'recovering', 'remission',
                'stages', 'stage', 'stage 1', 'stage 2', 'stage 3', 'stage 4',
                'stage i', 'stage ii', 'stage iii', 'stage iv',
                'early stage', 'late stage', 'advanced', 'metastatic',
                'spread', 'spreading', 'has it spread', 'metastasis',
                'how long', 'how long treatment', 'duration',
                'side effects', 'side effect', 'hair loss',
                'cost', 'expensive', 'afford', 'affordable',
                'options', 'what are my options', 'what can be done',
                'is there hope', 'hope', 'hopeful', 'die', 'death', 'fatal',
                'kill', 'deadly', 'terminal', 'life expectancy',
                // French
                'traitement', 'guérir', 'guérison', 'opération',
                'chirurgie', 'chimiothérapie', 'radiothérapie',
                'hormonothérapie', 'survie', 'taux de survie',
                'stade', 'stades', 'métastase', 'pronostic',
                'rémission', 'récupération', 'effets secondaires',
                'coût', 'espoir', 'mortel',
                // Kinyarwanda
                'kuvura', 'gukira', 'ubuvuzi', 'imiti', 'nakira', 'nivuje',
                'kubaga', 'kubagwa', 'gukira kanseri',
                'chimiotherapi', 'radiotherapi',
                'ikiciro', 'ibyiciro', 'gukwira',
                'ikizere', 'gupfa', 'guhemuka',
            ],
            'response' => [
                'en' => "Breast cancer IS treatable, especially when found early. There is real hope.\n\nTreatment options:\n• Surgery — Removing the tumor (lumpectomy) or the entire breast (mastectomy). Often the first step.\n• Chemotherapy — Medicines that kill cancer cells throughout the body. May cause side effects like hair loss and fatigue.\n• Radiation therapy — Targeted energy to destroy remaining cancer cells after surgery.\n• Hormone therapy — For cancers that grow in response to estrogen/progesterone. Taken for years after treatment.\n• Targeted therapy — Newer medicines that attack specific features of cancer cells.\n• Immunotherapy — Helps your immune system fight cancer.\n\nSurvival rates by stage (5-year survival):\n• Stage I (early): Over 90%\n• Stage II: About 80–90%\n• Stage III: About 50–70%\n• Stage IV (advanced/metastatic): Treatment can extend life and improve quality of life significantly\n\nTreatment is often a combination of several methods. Your doctor will recommend the best plan based on the type, stage, and characteristics of the cancer.\n\nThe most important factor is EARLY DETECTION. The sooner it is found, the more options are available and the better the outcome.",
                'fr' => "Le cancer du sein EST traitable, surtout quand il est détecté tôt.\n\nOptions de traitement :\n• Chirurgie — Retirer la tumeur (tumorectomie) ou le sein entier (mastectomie)\n• Chimiothérapie — Médicaments qui détruisent les cellules cancéreuses. Peut causer perte de cheveux et fatigue.\n• Radiothérapie — Énergie ciblée pour détruire les cellules restantes\n• Hormonothérapie — Pour les cancers sensibles aux hormones\n• Thérapie ciblée — Médicaments qui attaquent des caractéristiques spécifiques\n• Immunothérapie — Aide le système immunitaire à combattre le cancer\n\nTaux de survie à 5 ans :\n• Stade I : Plus de 90%\n• Stade II : Environ 80–90%\n• Stade III : Environ 50–70%\n• Stade IV : Le traitement peut prolonger la vie significativement\n\nLe facteur le plus important est la DÉTECTION PRÉCOCE.",
                'rw' => "Kanseri y'amabere IRASHOBORA gukira, cyane cyane iyo yavumbuwe kare. Hari ikizere.\n\nUburyo bwo kuvura:\n• Kubaga — Gukuraho ikibyimba cyangwa ibere ryose\n• Chimiotherapi — Imiti ica ingirabuzimafatizo za kanseri mu mubiri wose\n• Radiotherapi — Ingufu zigenewe kurimbura ingirabuzimafatizo za kanseri zisigaye\n• Kuvura hormone — Ku kanseri ikura bitewe na hormone\n• Imiti igenewe — Imiti mishya igaba ingirabuzimafatizo za kanseri gusa\n\nIgipimo cyo gukira (mu myaka 5):\n• Ikiciro cya I: Hejuru ya 90%\n• Ikiciro cya II: Hagati ya 80–90%\n• Ikiciro cya III: Hagati ya 50–70%\n• Ikiciro cya IV: Ubuvuzi bushobora kongeraho imyaka\n\nIkintu cy'ingenzi cyane ni KUVUMBURA KARE. Uko yavumbuwe kare ni ko hari uburyo bwinshi bwo kuvura.",
            ],
        ],

        // ═══════════════════════════════════════════════════════════
        // TOPIC 6: WHAT IS BREAST CANCER
        // ═══════════════════════════════════════════════════════════
        'what_is' => [
            'keywords' => [
                // English
                'what is breast cancer', 'what is cancer', 'what\'s breast cancer',
                'whats breast cancer', 'what\'s cancer',
                'explain breast cancer', 'explain cancer', 'tell me about breast cancer',
                'tell me about cancer', 'about breast cancer', 'about cancer',
                'definition', 'define', 'meaning',
                'how does cancer start', 'how does cancer begin', 'how cancer starts',
                'how cancer develops', 'how cancer forms', 'how cancer works',
                'understand cancer', 'understand breast cancer',
                'what exactly is', 'cancer explained',
                'benign', 'malignant', 'tumor', 'tumour', 'normal',
                'benign vs malignant', 'difference between benign and malignant',
                'types of breast cancer', 'type of cancer', 'cancer types',
                'ductal', 'lobular', 'invasive', 'in situ', 'dcis',
                'carcinoma', 'sarcoma', 'inflammatory',
                'triple negative', 'her2', 'er positive', 'pr positive',
                'how common', 'how many women', 'statistics', 'prevalence',
                'is it common', 'common cancer', 'most common',
                // French
                'qu\'est-ce que le cancer', 'c\'est quoi le cancer',
                'c\'est quoi', 'expliquer le cancer', 'définition',
                'bénin', 'malin', 'tumeur', 'types de cancer',
                'carcinome', 'inflammatoire',
                // Kinyarwanda
                'kanseri y\'amabere ni iki', 'kanseri ni iki',
                'sobanura kanseri', 'gusobanura',
                'ikibyimba', 'ubwoko bwa kanseri',
                'bisanzwe', 'bibi',
            ],
            'response' => [
                'en' => "Breast cancer occurs when cells in the breast grow abnormally and out of control, forming a tumor. Not all tumors are cancer:\n\n• Normal — Healthy breast tissue with no abnormal growths. This is what we want to see.\n• Benign — Abnormal growths that are NOT cancer. They stay in one place and do not spread to other parts of the body. Examples: cysts, fibroadenomas.\n• Malignant — These ARE cancer. They can invade nearby tissue and spread (metastasize) to other organs like bones, lungs, or liver.\n\nCommon types of breast cancer:\n• Ductal carcinoma — Starts in the milk ducts (most common, about 80%)\n• Lobular carcinoma — Starts in the milk-producing glands\n• Inflammatory breast cancer — Rare but aggressive, causes redness and swelling\n• Triple-negative — Does not respond to hormone therapy, treated with chemo\n\nBreast cancer is the most common cancer in women worldwide. When detected at Stage I, the survival rate is over 90%. This is why regular screening is so important — early detection saves lives.",
                'fr' => "Le cancer du sein survient quand les cellules du sein se développent de manière anormale et incontrôlée, formant une tumeur :\n\n• Normal — Tissu mammaire sain sans croissance anormale.\n• Bénin — Croissances anormales qui ne sont PAS un cancer. Elles ne se propagent pas. Exemples : kystes, fibroadénomes.\n• Malin (Malignant) — Ce SONT des cancers. Ils peuvent envahir les tissus voisins et se propager à d'autres organes.\n\nTypes courants :\n• Carcinome canalaire — Commence dans les canaux lactifères (le plus courant, environ 80%)\n• Carcinome lobulaire — Commence dans les glandes productrices de lait\n• Cancer inflammatoire — Rare mais agressif\n• Triple négatif — Ne répond pas à l'hormonothérapie\n\nDétecté au Stade I, le taux de survie est supérieur à 90%. La détection précoce sauve des vies.",
                'rw' => "Kanseri y'amabere ibaho iyo ingirabuzimafatizo mu ibere zikura mu buryo butasanzwe, zikaba ikibyimba. Ibiryimba byose si kanseri:\n\n• Bisanzwe (Normal) — Amabere mazima adafite ikibyimba. Ibi ni byo dushaka kubona.\n• Ibiryimba bisanzwe (Benign) — Gukura gutasanzwe ATARI kanseri. Bigumaaho ahantu hamwe ntibikwire ahandi. Urugero: ibikuba by'amazi, fibroadenome.\n• Ibiryimba bibi (Malignant) — Ibi NI kanseri. Bishobora gukwira mu bice bya hafi no mu bindi bice by'umubiri nk'amagufwa, ibihaha, cyangwa umwijima.\n\nUbwoko busanzwe bwa kanseri y'amabere:\n• Kanseri y'imiyoboro — Itangirira mu miyoboro y'amata (nyinshi cyane, hafi 80%)\n• Kanseri y'uturemangingo — Itangirira mu turemangingo dukora amata\n\nKanseri y'amabere ni kanseri isanzwe cyane mu bagore ku isi. Iyo yavumbuwe ku kiciro cya I, igipimo cyo gukira kirenze 90%. Ni yo mpamvu gusuzumwa buri gihe ari ingenzi — kuvumbura kare bikiza ubuzima.",
            ],
        ],

        // ═══════════════════════════════════════════════════════════
        // TOPIC 7: GETTING HELP / REFERRALS
        // ═══════════════════════════════════════════════════════════
        'getting_help' => [
            'keywords' => [
                // English
                'community health worker', 'chw', 'health worker',
                'where to go', 'where can i go', 'where should i go',
                'help', 'help me', 'i need help', 'need help',
                'find a doctor', 'find doctor', 'see a doctor', 'see doctor',
                'nearest clinic', 'nearest hospital', 'nearby clinic', 'nearby hospital',
                'hospital', 'clinic', 'health facility', 'health centre', 'health center',
                'referral', 'refer me', 'referred',
                'appointment', 'make appointment', 'book appointment',
                'who to talk to', 'who should i see', 'who to see',
                'what do i do', 'what should i do', 'what now',
                'next steps', 'next step', 'what to do next',
                'support', 'support group', 'counseling', 'counselling',
                'hotline', 'helpline', 'phone number', 'contact',
                'insurance', 'mutuelle', 'pay', 'payment', 'free',
                'butaro', 'chuk', 'kibagabaga', 'kanombe',
                // French
                'agent de santé', 'agent de santé communautaire',
                'centre de santé', 'hôpital', 'clinique',
                'aide', 'aidez-moi', 'besoin d\'aide',
                'où aller', 'où consulter', 'trouver un médecin',
                'orientation', 'rendez-vous',
                'soutien', 'groupe de soutien', 'conseil',
                'assurance', 'gratuit', 'paiement',
                // Kinyarwanda
                'umujyanama w\'ubuzima', 'umujyanama', 'abajyanama',
                'ivuriro', 'ibitaro', 'ikigo nderabuzima',
                'ubufasha', 'mfashe', 'ndashaka ubufasha',
                'muganga', 'kwa muganga', 'gusura muganga',
                'koherezwa', 'guherekezwa',
                'mituweli', 'ubwishingizi', 'ubuntu',
            ],
            'response' => [
                'en' => "How to get help in Rwanda:\n\n• Community Health Workers (CHWs) — Your first point of contact. They can guide you to the nearest health facility, help arrange referrals, and provide follow-up support.\n\n• Health Centers — Visit your nearest health center and ask for a clinical breast examination. Available in every sector.\n\n• District Hospitals — For ultrasound, further diagnostic tests, and specialist consultation. Ask your health center for a referral.\n\n• Specialized Centers:\n  - Butaro Cancer Center of Excellence (Partners In Health) — Specialized cancer care in Northern Province\n  - CHUK (Centre Hospitalier Universitaire de Kigali) — University hospital with oncology services\n  - Rwanda Military Hospital (Kanombe) — Also provides cancer services\n  - King Faisal Hospital — Advanced diagnostic and treatment facilities\n\n• Mutuelle de Santé (Community Health Insurance) — Covers many screening and treatment costs. Make sure your membership is active.\n\nDo not delay seeking help. Early consultation leads to better outcomes. If you're unsure where to start, talk to your local CHW.",
                'fr' => "Comment obtenir de l'aide au Rwanda :\n\n• Agents de Santé Communautaire — Votre premier point de contact. Ils peuvent vous orienter vers l'établissement de santé le plus proche.\n\n• Centres de santé — Visitez votre centre de santé le plus proche. Demandez un examen clinique des seins.\n\n• Hôpitaux de district — Pour échographie et tests diagnostiques. Demandez une orientation.\n\n• Centres spécialisés :\n  - Centre d'Excellence de Butaro — Soins spécialisés en cancérologie\n  - CHUK (Kigali) — Services d'oncologie\n  - Hôpital Militaire de Kanombe\n  - Hôpital King Faisal\n\n• Mutuelle de Santé — Couvre les frais de dépistage et traitement. Vérifiez que votre adhésion est active.\n\nNe tardez pas à consulter.",
                'rw' => "Uko wabona ubufasha mu Rwanda:\n\n• Abajyanama b'ubuzima — Ni bo wa mbere uvugana na bo. Bashobora kukuyobora ku ivuriro rya hafi.\n\n• Ibigo nderabuzima — Sura ikigo nderabuzima cya hafi usabe gusuzumwa amabere.\n\n• Ibitaro by'akarere — Ku isuzuma rya echografi n'ibindi bipimo. Saba koherezwa.\n\n• Ibigo by'umwihariko:\n  - Ikigo cya Butaro (Partners In Health) — Ubuvuzi bw'umwihariko bwa kanseri\n  - CHUK i Kigali — Ibitaro bikuru bifite ubuvuzi bwa kanseri\n  - Ibitaro bya Gisirikare (Kanombe)\n  - King Faisal Hospital\n\n• Mituweli y'Ubuzima — Ifasha kwishyura ibipimo n'ubuvuzi. Menya neza ko ifunguye.\n\nNtutinze gushaka ubufasha. Kujya kwa muganga kare bitanga ibyiza byinshi. Niba utazi aho gutangirira, vugana n'umujyanama w'ubuzima.",
            ],
        ],

        // ═══════════════════════════════════════════════════════════
        // TOPIC 8: BREASTFEEDING & CANCER
        // ═══════════════════════════════════════════════════════════
        'breastfeeding' => [
            'keywords' => [
                // English
                'breastfeeding', 'breast feeding', 'breast milk', 'breastmilk',
                'nursing', 'nurse', 'lactating', 'lactation',
                'pregnant', 'pregnancy', 'expecting',
                'baby', 'babies', 'infant', 'newborn', 'child',
                'can i breastfeed', 'safe to breastfeed',
                'while pregnant', 'during pregnancy',
                'after pregnancy', 'postpartum',
                'fertility', 'trying to conceive', 'ttc',
                // French
                'allaitement', 'allaiter', 'lait maternel',
                'enceinte', 'grossesse', 'bébé', 'nourrisson',
                'nourrir', 'post-partum', 'fertilité',
                // Kinyarwanda
                'konsa', 'gusama', 'amata y\'umubyeyi', 'wakonsa ufite kanseri',
                'imbanyi', 'gutwita', 'umwana', 'wakonsa', 'nakonsa',
                'kubyara', 'nyuma yo kubyara',
            ],
            'response' => [
                'en' => "Breastfeeding and breast cancer:\n\n• Breastfeeding may LOWER your risk of breast cancer. The protective effect increases with duration — especially if you breastfeed for a total of one year or more across all pregnancies.\n\n• Why? Breastfeeding reduces the total number of menstrual cycles in your lifetime, lowering estrogen exposure.\n\n• During breastfeeding, you should still do monthly self-exams. Changes in your breasts are normal during this time (engorgement, milk ducts), but report any persistent lump that doesn't go away to your health provider.\n\n• If you are pregnant or breastfeeding and notice a persistent lump, skin change, or bloody nipple discharge that is not related to breastfeeding, see a doctor promptly. Breast cancer during pregnancy is rare but possible.\n\n• If you have been diagnosed with breast cancer, discuss breastfeeding with your oncologist. Some treatments are not compatible with breastfeeding.\n\nBreastfeeding is healthy for both mother and child. It provides nutritional benefits to your baby AND has a protective effect against breast cancer for you.",
                'fr' => "Allaitement et cancer du sein :\n\n• L'allaitement peut RÉDUIRE votre risque de cancer du sein. L'effet protecteur augmente avec la durée — surtout si vous allaitez pendant un an ou plus au total.\n\n• Pourquoi ? L'allaitement réduit le nombre total de cycles menstruels, diminuant l'exposition aux œstrogènes.\n\n• Pendant l'allaitement, continuez les auto-examens mensuels. Les changements sont normaux pendant cette période, mais signalez toute bosse persistante.\n\n• Si vous êtes enceinte ou allaitez et remarquez une bosse persistante ou un écoulement sanglant non lié à l'allaitement, consultez rapidement.\n\nL'allaitement est bénéfique pour la mère et l'enfant, et a un effet protecteur contre le cancer du sein.",
                'rw' => "Konsa na kanseri y'amabere:\n\n• Konsa bishobora KUGABANYA ibyago byo kugira kanseri y'amabere. Igihe ukonsa kirekire ni ko birinda — cyane iyo ukonsa umwaka n'inyuma.\n\n• Kubera iki? Konsa kugabanya umubare w'imvura mu buzima bwawe, bigatuma hormone y'estrogeni igabanuka.\n\n• Mu gihe ukonsa, komeza kwisuzuma buri kwezi. Impinduka mu mabere ni ibisanzwe muri iki gihe, ariko menyesha umuganga igikuba cyose kidashira.\n\n• Niba utwite cyangwa ukonsa kandi ukabona igikuba kidashira, impinduka z'uruhu, cyangwa amaraso ava mu mutwaro adahuriye no konsa, gana umuganga vuba.\n\nKonsa ni byiza ku mubyeyi n'umwana, kandi birinda kanseri y'amabere.",
            ],
        ],

        // ═══════════════════════════════════════════════════════════
        // TOPIC 9: MYTHS & MISCONCEPTIONS
        // ═══════════════════════════════════════════════════════════
        'myths' => [
            'keywords' => [
                // English (very broad)
                'myth', 'myths', 'mythes', 'misconception', 'misconceptions',
                'true or false', 'is it true', 'is it true that',
                'is that true', 'fact or fiction', 'facts',
                'rumor', 'rumour', 'rumors', 'rumours',
                'false', 'fake', 'lie', 'lies', 'not true', 'untrue',
                'heard that', 'someone told me', 'they say', 'people say',
                'i heard', 'is it possible',
                'can men get', 'men cancer', 'male breast cancer', 'man breast',
                'deodorant', 'antiperspirant', 'deodorant cause',
                'bra cause', 'bra', 'wearing bras', 'tight bra', 'underwire',
                'phone cause', 'cell phone', 'mobile phone', 'radiation phone',
                'contagious', 'catching', 'catch cancer', 'spread from person',
                'pass on cancer', 'infectious', 'transmit',
                'inherited', 'only inherited', 'only genetic',
                'only old women', 'young women', 'young people',
                'only women', 'just women', 'women only',
                'injury cause', 'hit breast', 'bump breast', 'trauma',
                'size matters', 'big breasts', 'small breasts', 'breast size',
                'stress cause', 'stress causes cancer', 'anxiety cause',
                'sugar cause', 'sugar feeds', 'sugar cancer',
                'needle biopsy spread', 'biopsy spread cancer',
                'implants cause', 'breast implants',
                'positive attitude', 'attitude cure', 'faith cure',
                'traditional medicine', 'herbal', 'herbs', 'natural cure',
                'alternative medicine', 'traditional healer',
                // French
                'mythe', 'mythes', 'vrai ou faux', 'idée reçue',
                'contagieux', 'rumeur', 'faux', 'on dit que',
                'déodorant', 'soutien-gorge', 'téléphone',
                'hommes', 'cancer chez les hommes',
                'guérisseur', 'médecine traditionnelle', 'plantes',
                // Kinyarwanda
                'ibinyoma', 'ni ukuri', 'kwandura', 'ibyaha',
                'se ni ukuri', 'abantu bavuga', 'numvise',
                'abagabo', 'imiti gakondo', 'umuvuzi gakondo',
                'imiti kamere', 'ibiti',
            ],
            'response' => [
                'en' => "Common myths about breast cancer — and the facts:\n\nMYTH: Breast cancer only affects old women.\nFACT: Women of ANY age can develop breast cancer. While risk increases with age, young women get it too.\n\nMYTH: If no one in my family had it, I'm safe.\nFACT: About 85% of breast cancers occur in women with NO family history.\n\nMYTH: Breast cancer is contagious.\nFACT: Cancer is NOT contagious. You cannot catch it from touching, kissing, or being near someone with cancer.\n\nMYTH: Only women get breast cancer.\nFACT: Men can also get breast cancer, though it is rare (less than 1% of cases).\n\nMYTH: Wearing a bra or using deodorant causes breast cancer.\nFACT: NO scientific evidence links bras, deodorant, or antiperspirant to breast cancer.\n\nMYTH: Cell phones cause breast cancer.\nFACT: There is no proven link between cell phones and breast cancer.\n\nMYTH: A lump always means cancer.\nFACT: Most breast lumps (about 80%) are benign — caused by cysts, infections, or hormonal changes. But every lump SHOULD be checked.\n\nMYTH: Hitting or bumping your breast causes cancer.\nFACT: Physical trauma does NOT cause breast cancer. But an injury may draw attention to a lump that was already there.\n\nMYTH: Small-breasted women have less risk.\nFACT: Breast size does NOT affect cancer risk.\n\nMYTH: Sugar feeds cancer / stress causes cancer.\nFACT: While a healthy diet and stress management are good for overall health, there is no direct evidence that sugar or stress causes breast cancer.\n\nMYTH: Traditional/herbal medicine can cure breast cancer.\nFACT: There is no scientifically proven herbal cure for breast cancer. Traditional remedies may delay proper treatment. Always seek medical care first — then discuss complementary options with your doctor.\n\nWhen in doubt, ask a healthcare professional. Do not let myths prevent you from getting screened.",
                'fr' => "Mythes courants sur le cancer du sein — et les faits :\n\nMYTHE : Seules les femmes âgées sont touchées.\nRÉALITÉ : Les femmes de tout âge peuvent développer un cancer du sein.\n\nMYTHE : Pas d'antécédents familiaux = pas de risque.\nRÉALITÉ : Environ 85% des cas surviennent sans antécédents familiaux.\n\nMYTHE : Le cancer du sein est contagieux.\nRÉALITÉ : Le cancer n'est PAS contagieux.\n\nMYTHE : Seules les femmes ont le cancer du sein.\nRÉALITÉ : Les hommes peuvent aussi en être atteints.\n\nMYTHE : Les soutiens-gorge ou déodorants causent le cancer.\nRÉALITÉ : AUCUNE preuve scientifique ne le confirme.\n\nMYTHE : Une bosse signifie toujours un cancer.\nRÉALITÉ : La plupart des bosses (environ 80%) sont bénignes. Mais chaque bosse doit être examinée.\n\nMYTHE : La taille des seins affecte le risque.\nRÉALITÉ : La taille des seins n'affecte PAS le risque.\n\nMYTHE : La médecine traditionnelle peut guérir le cancer.\nRÉALITÉ : Il n'existe aucun remède traditionnel prouvé. Consultez toujours un médecin d'abord.\n\nNe laissez pas les mythes vous empêcher de vous faire dépister.",
                'rw' => "Ibinyoma bikunze kumvikana ku kanseri y'amabere — n'ukuri:\n\nIKINYOMA: Kanseri y'amabere igera ku bagore bakuru gusa.\nUKURI: Abagore b'imyaka yose bashobora kugira kanseri y'amabere.\n\nIKINYOMA: Nta mateka y'umuryango = nta byago.\nUKURI: Hafi 85% by'indwara zibaho nta mateka y'umuryango.\n\nIKINYOMA: Kanseri y'amabere irandura.\nUKURI: Kanseri NTIYANDURA. Ntushobora kuyihabwa n'undi muntu.\n\nIKINYOMA: Abagore gusa ni bo bagira kanseri y'amabere.\nUKURI: Abagabo na bo bashobora kugira kanseri y'amabere, ariko ni gake.\n\nIKINYOMA: Deodorant cyangwa soutien-gorge bitera kanseri.\nUKURI: NTAGIHAMYA cy'ubumenyi gifasha ibi.\n\nIKINYOMA: Igikuba burigihe gisobanura kanseri.\nUKURI: Ibiryimba byinshi (hafi 80%) si kanseri. Ariko igikuba cyose kigomba gusuzumwa.\n\nIKINYOMA: Ubunini bw'amabere butera ibyago.\nUKURI: Ubunini bw'amabere NTIBUHINDURA ibyago.\n\nIKINYOMA: Imiti gakondo ishobora gukiza kanseri.\nUKURI: Nta miti gakondo yemejwe n'ubumenyi ikiza kanseri. Imiti gakondo ishobora gutinda ubuvuzi bwiza. Banza ujye kwa muganga.\n\nNtiwemere ibinyoma bikakubuza gusuzumwa.",
            ],
        ],
    ];

    // ═══════════════════════════════════════════════════════════════
    // GREETINGS
    // ═══════════════════════════════════════════════════════════════
    private array $greetings = [
        'en' => "Hello! I'm your breast health assistant. I can help you with:\n\n• How to do a breast self-exam\n• Warning signs & symptoms of breast cancer\n• Risk factors & how to reduce your risk\n• Screening guidelines (when and how to get tested)\n• Treatment options & survival rates\n• What breast cancer actually is (normal vs benign vs malignant)\n• Myths vs facts about breast cancer\n• How to find help, clinics & referrals in Rwanda\n• Breastfeeding & breast cancer\n\nWhat would you like to know?",
        'fr' => "Bonjour ! Je suis votre assistant de santé mammaire. Je peux vous aider avec :\n\n• Auto-examen des seins\n• Signes d'alerte et symptômes\n• Facteurs de risque et prévention\n• Recommandations de dépistage\n• Options de traitement\n• Normal vs bénin vs malin\n• Mythes et réalités\n• Trouver de l'aide au Rwanda\n• Allaitement et cancer du sein\n\nQue souhaitez-vous savoir ?",
        'rw' => "Muraho! Ndi umufasha wawe w'ubuzima bw'amabere. Nashobora kukubwira ku:\n\n• Kwisuzuma amabere\n• Ibimenyetso by'umugera\n• Ibyago n'uburyo bwo kwirinda\n• Amabwiriza yo gusuzumwa\n• Uburyo bwo kuvura\n• Bisanzwe vs benign vs malignant\n• Ibinyoma n'ukuri\n• Uko wabona ubufasha mu Rwanda\n• Konsa na kanseri y'amabere\n\nNi iki ushaka kumenya?",
    ];

    // ═══════════════════════════════════════════════════════════════
    // FALLBACKS
    // ═══════════════════════════════════════════════════════════════
    private array $fallbacks = [
        'en' => "I can help with breast cancer information. Try asking about:\n\n• \"How do I check my breasts?\" (self-exam)\n• \"What are the signs of breast cancer?\" (symptoms)\n• \"Am I at risk?\" (risk factors)\n• \"When should I get screened?\" (screening)\n• \"Can breast cancer be cured?\" (treatment)\n• \"What is breast cancer?\" (explanation)\n• \"Is it true that...?\" (myths)\n• \"Where can I get help?\" (referrals)\n• \"Does breastfeeding help?\" (breastfeeding)",
        'fr' => "Je peux vous aider sur le cancer du sein. Essayez de demander :\n\n• \"Comment examiner mes seins ?\" (auto-examen)\n• \"Quels sont les signes ?\" (symptômes)\n• \"Suis-je à risque ?\" (facteurs de risque)\n• \"Quand me faire dépister ?\" (dépistage)\n• \"Le cancer est-il guérissable ?\" (traitement)\n• \"C'est quoi le cancer du sein ?\" (explication)\n• \"Est-ce vrai que... ?\" (mythes)\n• \"Où trouver de l'aide ?\" (orientation)",
        'rw' => "Nashobora kugufasha ku makuru ya kanseri y'amabere. Gerageza kubaza:\n\n• \"Nasuzuma amabere nte?\" (kwisuzuma)\n• \"Ibimenyetso ni ibihe?\" (ibimenyetso)\n• \"Mfite ibyago?\" (ibyago)\n• \"Nasuzumwa ryari?\" (gusuzumwa)\n• \"Kanseri irakira?\" (ubuvuzi)\n• \"Kanseri ni iki?\" (gusobanura)\n• \"Ni ukuri ko...?\" (ibinyoma)\n• \"Nabona ubufasha hehe?\" (ubufasha)",
    ];

    // ═══════════════════════════════════════════════════════════════
    // RISK LEVEL RESPONSES (for screening results)
    // ═══════════════════════════════════════════════════════════════
    private array $riskResponses = [
        'high' => [
            'en' => "Your risk assessment indicates a HIGH risk level (score: {score}). This does NOT mean you have cancer, but we strongly recommend visiting a health facility for a clinical breast examination as soon as possible. Please contact your Community Health Worker for a referral.",
            'fr' => "Votre évaluation indique un niveau de risque ÉLEVÉ (score : {score}). Cela ne signifie PAS que vous avez un cancer, mais nous recommandons fortement de visiter un établissement de santé pour un examen clinique dès que possible.",
            'rw' => "Isuzuma ryawe ryerekanye ibyago BIKOMEYE (amanota: {score}). Ibi NTIBISOBANURA ko ufite kanseri, ariko turagushishikariza cyane kujya ku kigo nderabuzima vuba bishoboka. Vugana n'umujyanama w'ubuzima.",
        ],
        'moderate' => [
            'en' => "Your risk assessment indicates a MODERATE risk level (score: {score}). We recommend scheduling a clinical breast examination within the next month. Continue doing monthly self-exams and note any changes.",
            'fr' => "Votre évaluation indique un niveau de risque MODÉRÉ (score : {score}). Planifiez un examen clinique dans le mois à venir. Continuez les auto-examens mensuels.",
            'rw' => "Isuzuma ryawe ryerekanye ibyago BISANZWE (amanota: {score}). Turagushishikariza gushaka gusuzumwa na muganga mu kwezi gutaha. Komeza kwisuzuma buri kwezi.",
        ],
        'low' => [
            'en' => "Your risk assessment indicates a LOW risk level (score: {score}). This is a positive result! Continue with monthly self-examinations and routine screenings as recommended for your age group.",
            'fr' => "Votre évaluation indique un niveau de risque FAIBLE (score : {score}). C'est un bon résultat ! Continuez les auto-examens mensuels et les dépistages de routine.",
            'rw' => "Isuzuma ryawe ryerekanye ibyago BIKE (amanota: {score}). Ibi ni ibyiza! Komeza kwisuzuma buri kwezi no gusuzumwa nk'uko bisabwa ku myaka yawe.",
        ],
    ];

    // ═══════════════════════════════════════════════════════════════
    // LANGUAGE DETECTION
    // ═══════════════════════════════════════════════════════════════
    private function detectLanguage(string $message): string
    {
        $lower = mb_strtolower($message);

        // Kinyarwanda indicators
        $rwWords = [
            // Greetings & common phrases
            'muraho', 'amakuru', 'mwiriwe', 'bite', 'ndashaka', 'mfasha',
            'mfashe', 'ese', 'ni iki', 'niki', 'numvise', 'abantu bavuga',

            // Body / health general
            'ubuzima', 'umubiri', 'muganga', 'kwa muganga', 'gusura muganga',
            'ivuriro', 'ibitaro', 'ikigo nderabuzima', 'ubufasha',

            // Breast-specific
            'amabere', 'ibere', 'kanseri', "kanseri y'amabere", "kanseri y'ibere",

            // Self-exam
            'gusuzuma', 'kwisuzuma', 'gusuzumwa', 'kwigenzura', 'kugenzurwa',
            'isuzuma', 'igenzura', 'gupima', 'gupimwa', 'nakisuzuma', 'nisuzuma',
            'kwisuzuma buri kwezi', 'kwireba', 'gukora isuzuma',

            // Symptoms
            'ibimenyetso', 'ububabare', 'igikuba', 'ubukomere', 'kubyimba',
            'impinduka', 'amaraso', 'ibisohoka', 'umumero', 'ibibyimba',
            'inkokora', 'kurwara', 'kuribwa', 'gukomera', 'guhindura ibara',

            // Risk & prevention
            'ibyago', 'impamvu', 'kwirinda', 'gukingira', 'kugabanya',
            'umuryango', 'amateka', 'imyitozo', 'ibiro', 'inzoga',

            // Screening & diagnosis
            'mammografi', 'echografi', 'kumenya', 'kumenya kare', 'koherezwa',

            // Treatment
            'kuvura', 'gukira', 'ubuvuzi', 'imiti', 'kubaga', 'kubagwa',
            'chimiotherapi', 'radiotherapi', 'ikiciro', 'ibyiciro', 'ikizere',
            'gupfa', 'nakira',

            // What is cancer
            'ikibyimba', 'ubwoko', 'gusobanura', 'sobanura',

            // Getting help
            'umujyanama', 'abajyanama', 'mituweli', 'ubwishingizi',

            // Breastfeeding
            'konsa', 'gusama', 'imbanyi', 'gutwita', 'umwana', 'umubyeyi',
            'wakonsa', 'nakonsa', 'kubyara', 'imvura',

            // Myths
            'ibinyoma', 'ukuri', 'kwandura', 'abagabo', 'imiti gakondo',
            'umuvuzi', 'komeza',
        ];
        foreach ($rwWords as $w) {
            if (str_contains($lower, $w)) return 'rw';
        }

        // French indicators
        $frWords = [
            // Greetings & common phrases
            'bonjour', 'bonsoir', 'salut', 'coucou', 'merci', 'aidez',
            "s'il vous", 'pouvez', 'comment', 'est-ce que', "qu'est",
            'je veux', "j'ai", 'je suis', 'on dit que',

            // Breast / cancer
            'cancer du sein', 'les seins', 'sein', 'mamelon', 'tumeur',

            // Symptoms
            'symptômes', 'signes', 'bosse', 'boule', 'grosseur', 'douleur',
            'écoulement', 'rougeur', 'gonflement', 'ganglion', 'aisselle',
            'masse', 'bénin', 'malin',

            // Risk & prevention
            'facteurs', 'risque', 'prévention', 'prévenir', 'éviter',
            'antécédents', 'génétique', 'obésité', 'alcool', 'hormones',
            'protéger',

            // Screening
            'dépistage', 'mammographie', 'échographie', 'examen',
            'détection précoce', 'quand consulter',

            // Treatment
            'traitement', 'guérir', 'guérison', 'chirurgie', 'chimiothérapie',
            'radiothérapie', 'hormonothérapie', 'rémission', 'stade',
            'métastase', 'effets secondaires', 'espoir',

            // Health system
            'médecin', 'hôpital', 'santé', 'centre de santé', 'orientation',
            'assurance', 'gratuit',

            // Breastfeeding
            'allaitement', 'allaiter', 'enceinte', 'grossesse', 'bébé',
            'nourrisson',

            // Myths
            'mythe', 'vrai', 'faux', 'contagieux', 'rumeur', 'déodorant',
            'soutien-gorge', 'médecine traditionnelle',
        ];
        foreach ($frWords as $w) {
            if (str_contains($lower, $w)) return 'fr';
        }

        return 'en';
    }

    // ═══════════════════════════════════════════════════════════════
    // MAIN RESPONSE GENERATOR
    // ═══════════════════════════════════════════════════════════════
    public function generate(?string $message, $prediction = null, ?string $lang = null): string
    {
        // Detect language if not provided
        if (!$lang && $message) {
            $lang = $this->detectLanguage($message);
        }
        $lang = $lang ?? 'en';

        // If there's a risk assessment result, respond with contextual advice
        if ($prediction && isset($prediction['risk_level'])) {
            $level = $prediction['risk_level'];
            $score = $prediction['risk_score'] ?? 'N/A';

            $template = $this->riskResponses[$level][$lang] ?? $this->riskResponses[$level]['en'];
            $response = str_replace('{score}', $score, $template);

            $disclaimers = [
                'en' => "\n\nReminder: This is a preliminary screening tool and not a medical diagnosis. Please consult a healthcare professional for proper evaluation.",
                'fr' => "\n\nRappel : Ceci est un outil de dépistage préliminaire et non un diagnostic médical. Veuillez consulter un professionnel de santé.",
                'rw' => "\n\nIbuka: Ibi ni igikoresho cyo gusuzuma cy'ibanze, si igihango cya muganga. Gana umuganga kugira ngo usuzumwe neza.",
            ];

            return $response . ($disclaimers[$lang] ?? $disclaimers['en']);
        }

        // No message provided
        if (!$message) {
            return $this->fallbacks[$lang] ?? $this->fallbacks['en'];
        }

        $messageLower = mb_strtolower($message);

        // Check for greetings first
        $greetingWords = [
            'hi', 'hello', 'hey', 'good morning', 'good afternoon', 'good evening',
            'hi there', 'hey there', 'howdy', 'greetings', 'what can you do',
            'help me', 'start', 'menu', 'options',
            'bonjour', 'bonsoir', 'salut', 'coucou',
            'muraho', 'amakuru', 'bite', 'mwiriwe',
        ];
        foreach ($greetingWords as $greeting) {
            if (str_contains($messageLower, $greeting)) {
                return $this->greetings[$lang] ?? $this->greetings['en'];
            }
        }

        // Match against knowledge base
        foreach ($this->knowledge as $topic) {
            foreach ($topic['keywords'] as $keyword) {
                if (str_contains($messageLower, $keyword)) {
                    return $topic['response'][$lang] ?? $topic['response']['en'];
                }
            }
        }

        // No match — return fallback with suggestions
        return $this->fallbacks[$lang] ?? $this->fallbacks['en'];
    }
}