import List from "@/components/list"
import { getPermission } from "@/lib/permissions/contacts"
import { useNavigation } from "@react-navigation/native"
import { useEffect, useState } from "react"
import { SafeAreaProvider, SafeAreaView } from "react-native-safe-area-context"
import type { SearchBarProps } from "react-native-screens"

export default function AddFriendsModal() {
	const navigation = useNavigation()

	const [query, setQuery] = useState("")
	useEffect(() => {
		navigation.setOptions({
			headerSearchBarOptions: {
				inputType: "phone",
				placeholder: "Search",
				onChangeText: e => setQuery(e.nativeEvent.text),
			} satisfies SearchBarProps,
		})
	}, [navigation])

	const [contacts, setContacts] = useState<string[] | null>(null)
	useEffect(() => {
		getPermission().then(async granted => {
			if (!granted) return
			setContacts([])
		})
	}, [])

	return (
		<SafeAreaProvider>
			<SafeAreaView>
				{!!query && <List.Container title="Search Results" />}
				{!!contacts && <List.Container title="Contacts" />}
			</SafeAreaView>
		</SafeAreaProvider>
	)
}
