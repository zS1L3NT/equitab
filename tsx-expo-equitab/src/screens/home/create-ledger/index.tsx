import { Header } from "@react-navigation/elements"
import { Text, View } from "react-native"

export default function CreateLedgerScreen() {
	return (
		<>
			<Header title="Create Ledger" back={{ title: "Home", href: "" }} />
			<View>
				<Text>Create Ledger</Text>
			</View>
		</>
	)
}
